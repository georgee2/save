<?php

namespace App\Services;

use App\Mail\CustomerInviteMail;
use App\Mail\RegistrationAttemptMail;
use App\Models\Role;
use App\Models\User;
use App\Services\CustomerSync\CustomerSyncService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

/**
 * Shared customer-registration logic used by both the web controller and the app API.
 *
 * Registration is fully internal today. The ERP link is delegated to CustomerSyncService,
 * which is a no-op until the ERPNext integration sub-plan is executed.
 */
class CustomerRegistrationService
{
    public function __construct(protected CustomerSyncService $sync)
    {
    }

    /**
     * Register (or idempotently re-invite) a customer.
     *
     * @param array{name:string,email:string,phone?:string|null} $data
     * @return array{user: ?User, status: string}  status: 'created' | 'exists'
     */
    public function register(array $data, string $source = 'web'): array
    {
        $email = Str::lower(trim($data['email']));

        $existing = User::where('email', $email)->first();

        if ($existing) {
            $this->notifyExistingAccount($existing);

            return ['user' => null, 'status' => 'exists'];
        }

        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $email,
                'phone' => $this->normalizePhone($data['phone'] ?? null),
                'account_type' => 'customer',
                'source' => $source,
                'is_active' => true,
                'preferred_locale' => in_array($data['preferred_locale'] ?? null, ['en', 'ar'], true)
                    ? $data['preferred_locale']
                    : app()->getLocale(),
                'consent_at' => !empty($data['consent']) ? now() : null,
                // Unusable placeholder; the customer sets a real password via the invite link.
                'password' => bcrypt(Str::random(40)),
            ]);
        } catch (QueryException $e) {
            // Concurrency guard (master plan section 4.3): a simultaneous request
            // may have created this email between the check above and here. Treat a
            // unique-violation as the idempotent "re-invite existing" path.
            $duplicate = User::where('email', $email)->first();

            if ($duplicate) {
                $this->notifyExistingAccount($duplicate);

                return ['user' => null, 'status' => 'exists'];
            }

            throw $e;
        }

        $this->assignCustomerRole($user);

        // Deferred-ERP hook (no-op today).
        try {
            $this->sync->onCustomerRegistered($user);
        } catch (\Throwable $e) {
            Log::warning('Customer sync onCustomerRegistered failed: ' . $e->getMessage());
        }

        $this->sendInvite($user);

        return ['user' => $user, 'status' => 'created'];
    }

    /**
     * Tell the address owner, by email, that someone tried to register with their address.
     *
     * This used to throw a ValidationException whose wording distinguished four cases -
     * no account, activated customer, unactivated customer, and staff - which made
     * registration an oracle for whether an address exists, whether it has been activated,
     * and whether it belongs to staff. The caller now returns its ordinary success
     * response either way, and the fact is delivered here, where only the owner sees it.
     *
     * An unactivated customer gets their activation link resent instead, since that is
     * almost always what they were actually trying to do.
     */
    protected function notifyExistingAccount(User $existing): void
    {
        if ($existing->isCustomer() && is_null($existing->password_set_at) && $existing->is_active) {
            $this->sendInvite($existing);

            return;
        }

        // Cooldown shared with sendInvite's, so repeatedly submitting an address cannot be
        // used to flood its owner.
        $cooldownKey = 'registration-attempt:' . Str::lower($existing->email);

        if (!Cache::add($cooldownKey, true, now()->addMinutes(10))) {
            return;
        }

        dispatch(function () use ($existing) {
            try {
                Mail::to($existing->email)->send(new RegistrationAttemptMail($existing));
            } catch (\Throwable $e) {
                Log::warning('Registration-attempt notice failed: ' . $e->getMessage());
            }
        })->afterResponse();
    }

    /**
     * Light phone normalization: trim and collapse internal whitespace.
     */
    protected function normalizePhone(?string $phone): ?string
    {
        if ($phone === null) {
            return null;
        }

        $phone = preg_replace('/\s+/', ' ', trim($phone));

        return $phone === '' ? null : $phone;
    }

    /**
     * Send the set-password / verification invite email.
     */
    public function sendInvite(User $user): void
    {
        // Per-email cooldown (anti email-bomb): at most one invite per address
        // every 10 minutes, layered over the broker's built-in throttle. Skip
        // silently if we sent one recently.
        $cooldownKey = 'invite-cooldown:' . Str::lower($user->email);
        if (Cache::has($cooldownKey)) {
            return;
        }
        Cache::put($cooldownKey, true, now()->addMinutes(10));

        // Activation invites use the long-lived `invitations` broker so the link
        // does not expire in 60 minutes like a password-reset token.
        $token = Password::broker('invitations')->createToken($user);

        // Send the mail after the HTTP response is flushed so a slow SMTP round-trip
        // never blocks the form submission (QUEUE_CONNECTION=sync, so afterResponse
        // is what keeps the request fast without needing a queue worker).
        dispatch(function () use ($user, $token) {
            try {
                Mail::to($user->email)->send(new CustomerInviteMail($user, $token));
            } catch (\Throwable $e) {
                Log::warning('Customer invite email failed: ' . $e->getMessage());
            }
        })->afterResponse();
    }

    protected function assignCustomerRole(User $user): void
    {
        $role = Role::where('slug', 'website-user')->first();

        if ($role) {
            $user->roles()->syncWithoutDetaching([$role->id]);

            return;
        }

        Log::warning("Customer registration: 'website-user' role not found; user {$user->id} created without a role. Run the RolesAndPermissionsSeeder.");
    }
}
