<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Thin ERPNext (Frappe) REST client for customer + project data.
 *
 * DESIGN GOALS
 * - Fail-open: every method catches its own errors and returns a safe empty
 *   value (null / []). ERP downtime must never surface a 500 to a user or block
 *   registration. Callers still wrap calls defensively as well.
 * - Config-gated: does nothing unless services.erpnext.enabled + base_url are set.
 * - Read caching: project reads use Cache::remember with a short TTL.
 *
 * ============================================================================
 * DOCTYPE / FIELD MAP - CONFIRM WITH THE ERP TEAM BEFORE GO-LIVE
 * ----------------------------------------------------------------------------
 * The names below are the current assumptions (master plan section 12 open
 * questions). The ERP developers must confirm/adjust them; when they do, update
 * ONLY this map - the rest of the class is field-name agnostic.
 * ============================================================================
 */
class ErpNextService
{
    /**
     * Doctype names in ERPNext. Confirm with ERP team.
     */
    private const DOCTYPE_CUSTOMER = 'Customer';
    private const DOCTYPE_PROJECT = 'Project';

    /**
     * Field mapping: local meaning => ERPNext fieldname. Confirm with ERP team.
     */
    private const FIELD_MAP = [
        'customer_email' => 'email_id',
        'customer_name' => 'customer_name',
        'customer_phone' => 'mobile_no',
        'project_name' => 'project_name',
        'project_status' => 'status',
        'project_progress' => 'percent_complete',
        'project_customer' => 'customer',
        'project_contract' => 'custom_contract_ref',
    ];

    /**
     * Whether the integration is active. When false, all methods short-circuit.
     */
    public function isEnabled(): bool
    {
        return (bool) config('services.erpnext.enabled')
            && !empty(config('services.erpnext.base_url'));
    }

    /**
     * Find an ERP customer by email, or create one, and return its ERP id (name).
     * Returns null on any failure so the caller can proceed without linking.
     */
    public function findOrCreateCustomer(User $user): ?string
    {
        if (!$this->isEnabled()) {
            return null;
        }

        try {
            $existing = $this->findCustomerByEmail($user->email);
            if ($existing !== null) {
                return $existing;
            }

            // Setting email_id/mobile_no on create makes ERPNext auto-generate the
            // primary Contact (Customer.create_primary_contact). customer_group and
            // territory are usually mandatory - include the configured defaults so
            // creation does not fail on a standard ERPNext setup.
            $payload = [
                self::FIELD_MAP['customer_name'] => $user->name,
                self::FIELD_MAP['customer_email'] => $user->email,
                self::FIELD_MAP['customer_phone'] => $user->phone,
                'customer_type' => 'Individual',
            ];

            if ($group = config('services.erpnext.default_customer_group')) {
                $payload['customer_group'] = $group;
            }
            if ($territory = config('services.erpnext.default_territory')) {
                $payload['territory'] = $territory;
            }

            $response = $this->client()->post($this->url('/api/resource/' . rawurlencode(self::DOCTYPE_CUSTOMER)), $payload);

            if ($response->successful()) {
                return $response->json('data.name');
            }

            Log::warning('ERPNext findOrCreateCustomer non-2xx', [
                'status' => $response->status(),
                'email' => $user->email,
            ]);
        } catch (\Throwable $e) {
            Log::warning('ERPNext findOrCreateCustomer failed: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Look up an ERP customer id (name) by email. Returns null if not found/error.
     *
     * NOTE: Customer.email_id is a ReadOnly field derived from the primary Contact,
     * so this filter only matches customers that have a primary contact set. That is
     * always true for customers we create here (email_id triggers primary-contact
     * creation). Pre-existing ERP customers without a primary contact may be missed;
     * if the ERP setup stores email only on Contact, ask the ERP team for a custom
     * whitelisted email -> customer lookup method (see the requirements doc).
     */
    public function findCustomerByEmail(string $email): ?string
    {
        if (!$this->isEnabled()) {
            return null;
        }

        try {
            $filters = json_encode([[self::FIELD_MAP['customer_email'], '=', $email]]);

            $response = $this->client()->get($this->url('/api/resource/' . rawurlencode(self::DOCTYPE_CUSTOMER)), [
                'filters' => $filters,
                'limit_page_length' => 1,
            ]);

            if ($response->successful()) {
                return $response->json('data.0.name');
            }
        } catch (\Throwable $e) {
            Log::warning('ERPNext findCustomerByEmail failed: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Push profile changes to the ERP customer. Best-effort; never throws.
     */
    public function updateCustomer(string $erpCustomerId, array $fields): bool
    {
        if (!$this->isEnabled()) {
            return false;
        }

        try {
            $payload = [];
            foreach ($fields as $localKey => $value) {
                if (isset(self::FIELD_MAP[$localKey])) {
                    $payload[self::FIELD_MAP[$localKey]] = $value;
                }
            }

            if ($payload === []) {
                return false;
            }

            $response = $this->client()->put(
                $this->url('/api/resource/' . rawurlencode(self::DOCTYPE_CUSTOMER) . '/' . rawurlencode($erpCustomerId)),
                $payload
            );

            return $response->successful();
        } catch (\Throwable $e) {
            Log::warning('ERPNext updateCustomer failed: ' . $e->getMessage());

            return false;
        }
    }

    /**
     * List projects for an ERP customer. Cached; returns [] on failure.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getCustomerProjects(string $erpCustomerId): array
    {
        if (!$this->isEnabled() || $erpCustomerId === '') {
            return [];
        }

        return Cache::remember(
            'erp:customer_projects:' . $erpCustomerId,
            (int) config('services.erpnext.cache_ttl', 300),
            function () use ($erpCustomerId) {
                try {
                    $filters = json_encode([[self::FIELD_MAP['project_customer'], '=', $erpCustomerId]]);
                    $fields = json_encode(['name', self::FIELD_MAP['project_name'], self::FIELD_MAP['project_status'], self::FIELD_MAP['project_progress']]);

                    $response = $this->client()->get($this->url('/api/resource/' . rawurlencode(self::DOCTYPE_PROJECT)), [
                        'filters' => $filters,
                        'fields' => $fields,
                        'limit_page_length' => 100,
                    ]);

                    if ($response->successful()) {
                        return (array) $response->json('data', []);
                    }
                } catch (\Throwable $e) {
                    Log::warning('ERPNext getCustomerProjects failed: ' . $e->getMessage());
                }

                return [];
            }
        );
    }

    /**
     * Fetch full detail for one project. Cached; returns null on failure.
     *
     * @return array<string, mixed>|null
     */
    public function getProjectDetail(string $erpProjectId): ?array
    {
        if (!$this->isEnabled() || $erpProjectId === '') {
            return null;
        }

        return Cache::remember(
            'erp:project_detail:' . $erpProjectId,
            (int) config('services.erpnext.cache_ttl', 300),
            function () use ($erpProjectId) {
                try {
                    $response = $this->client()->get(
                        $this->url('/api/resource/' . rawurlencode(self::DOCTYPE_PROJECT) . '/' . rawurlencode($erpProjectId))
                    );

                    if ($response->successful()) {
                        return $response->json('data');
                    }
                } catch (\Throwable $e) {
                    Log::warning('ERPNext getProjectDetail failed: ' . $e->getMessage());
                }

                return null;
            }
        );
    }

    /**
     * Configured, authenticated HTTP client (Frappe token auth).
     */
    private function client(): \Illuminate\Http\Client\PendingRequest
    {
        $key = config('services.erpnext.api_key');
        $secret = config('services.erpnext.api_secret');

        return Http::withHeaders([
            'Authorization' => "token {$key}:{$secret}",
            'Accept' => 'application/json',
        ])->timeout((int) config('services.erpnext.timeout', 8));
    }

    /**
     * Build an absolute ERP URL from a path.
     */
    private function url(string $path): string
    {
        return rtrim((string) config('services.erpnext.base_url'), '/') . $path;
    }
}
