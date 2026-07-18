<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Services\CustomerRegistrationService;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Inbound ERPNext webhook: Customer created/updated in ERP -> upsert/link the
 * website user (master plan section 4.2).
 *
 * SAFETY
 * - Returns 404 while the integration is disabled (no attack surface, no route
 *   behavior change for the live site).
 * - HMAC-verifies the raw request body against ERPNEXT_WEBHOOK_SECRET (401 on
 *   mismatch). Timing-safe compare.
 * - Idempotency-key aware so retried webhooks do not double-process.
 * - Unique-violation on create is treated as the "link existing" path.
 */
class ErpWebhookController extends Controller
{
    /**
     * Header set by Frappe's native Webhook doctype (when "Webhook Secret" is
     * enabled): base64-encoded HMAC-SHA256 of the raw JSON body. Preferred, since
     * it needs no custom Server Script on the ERP side.
     */
    private const FRAPPE_SIGNATURE_HEADER = 'X-Frappe-Webhook-Signature';

    /**
     * Alternative header for a custom ERP Server Script: hex-encoded HMAC-SHA256
     * of the raw body. Supported so either integration style works.
     */
    private const SIGNATURE_HEADER = 'X-ERP-Signature';

    /** Optional header carrying a unique event id for idempotency. */
    private const IDEMPOTENCY_HEADER = 'X-ERP-Idempotency-Key';

    public function __construct(protected CustomerRegistrationService $registration)
    {
    }

    public function customer(Request $request): JsonResponse
    {
        // 1. Disabled -> behave as if the route does not exist.
        if (!config('services.erpnext.enabled')) {
            abort(404);
        }

        // 2. Verify HMAC signature over the raw payload.
        if (!$this->signatureValid($request)) {
            abort(401, 'Invalid signature.');
        }

        // 3. Idempotency: skip if we have already processed this event id.
        $eventId = $request->header(self::IDEMPOTENCY_HEADER);
        if ($eventId) {
            $idemKey = 'erp-webhook:' . $eventId;
            if (Cache::has($idemKey)) {
                return response()->json(['success' => true, 'status' => 'duplicate_ignored']);
            }
            Cache::put($idemKey, true, now()->addDay());
        }

        // 4. Extract + normalize the customer payload. Field names must match the
        //    ERP webhook mapping documented in ERP_DEVELOPER_REQUIREMENTS.md.
        $email = Str::lower(trim((string) $request->input('email')));
        $erpCustomerId = $request->input('erp_customer_id');
        $name = $request->input('name');
        $phone = $request->input('phone');

        if ($email === '' && empty($erpCustomerId)) {
            return response()->json(['success' => false, 'message' => 'email or erp_customer_id required'], 422);
        }

        try {
            $status = $this->upsertCustomer($email, $erpCustomerId, $name, $phone);
        } catch (\Throwable $e) {
            Log::error('ERP webhook customer upsert failed: ' . $e->getMessage(), [
                'email' => $email,
                'erp_customer_id' => $erpCustomerId,
            ]);

            return response()->json(['success' => false, 'message' => 'processing error'], 500);
        }

        return response()->json(['success' => true, 'status' => $status]);
    }

    /**
     * Find by erp_customer_id or email, then link an existing user or create one.
     * Returns 'linked' or 'created'.
     */
    private function upsertCustomer(string $email, ?string $erpCustomerId, ?string $name, ?string $phone): string
    {
        $user = null;

        if (!empty($erpCustomerId)) {
            $user = User::where('erp_customer_id', $erpCustomerId)->first();
        }

        if (!$user && $email !== '') {
            $user = User::where('email', $email)->first();
        }

        // Existing user -> LINK (keep password + account), ensure role + erp id.
        if ($user) {
            $updates = [];
            if (!empty($erpCustomerId) && $user->erp_customer_id !== $erpCustomerId) {
                $updates['erp_customer_id'] = $erpCustomerId;
            }
            $updates['synced_at'] = now();
            $user->updateQuietly($updates);

            $this->ensureCustomerRole($user);

            return 'linked';
        }

        // New user -> create as an ERP-sourced customer with an unusable password,
        // then send the set-password invite (mirrors CustomerRegistrationService).
        try {
            $user = User::create([
                'name' => $name ?: ($email !== '' ? Str::before($email, '@') : 'Customer'),
                'email' => $email,
                'phone' => $phone,
                'account_type' => 'customer',
                'source' => 'erp',
                'is_active' => true,
                'erp_customer_id' => $erpCustomerId,
                'preferred_locale' => app()->getLocale(),
                'synced_at' => now(),
                'password' => bcrypt(Str::random(40)),
            ]);
        } catch (QueryException $e) {
            // Concurrency: a parallel request created it -> link instead.
            $existing = null;
            if (!empty($erpCustomerId)) {
                $existing = User::where('erp_customer_id', $erpCustomerId)->first();
            }
            if (!$existing && $email !== '') {
                $existing = User::where('email', $email)->first();
            }

            if ($existing) {
                $existing->updateQuietly(['synced_at' => now()]);
                $this->ensureCustomerRole($existing);

                return 'linked';
            }

            throw $e;
        }

        $this->ensureCustomerRole($user);

        // Only send an activation invite when we have a deliverable email.
        if ($email !== '') {
            $this->registration->sendInvite($user);
        }

        return 'created';
    }

    /**
     * Ensure the user has the customer (website-user) role.
     */
    private function ensureCustomerRole(User $user): void
    {
        $role = Role::where('slug', 'website-user')->first();

        if ($role) {
            $user->roles()->syncWithoutDetaching([$role->id]);
        }
    }

    /**
     * Timing-safe HMAC-SHA256 verification of the raw request body. Accepts either
     * the Frappe-native signature (base64, X-Frappe-Webhook-Signature) or a custom
     * Server Script signature (hex, X-ERP-Signature). Both are keyed on the shared
     * webhook secret and computed over the exact raw body bytes.
     */
    private function signatureValid(Request $request): bool
    {
        $secret = (string) config('services.erpnext.webhook_secret');

        if ($secret === '') {
            return false;
        }

        $body = $request->getContent();

        // Frappe native Webhook doctype: base64(HMAC-SHA256(raw_body)).
        $frappeSig = (string) $request->header(self::FRAPPE_SIGNATURE_HEADER, '');
        if ($frappeSig !== '') {
            $expected = base64_encode(hash_hmac('sha256', $body, $secret, true));
            if (hash_equals($expected, $frappeSig)) {
                return true;
            }
        }

        // Custom Server Script: hex(HMAC-SHA256(raw_body)).
        $customSig = (string) $request->header(self::SIGNATURE_HEADER, '');
        if ($customSig !== '') {
            $expected = hash_hmac('sha256', $body, $secret);
            if (hash_equals($expected, $customSig)) {
                return true;
            }
        }

        return false;
    }
}
