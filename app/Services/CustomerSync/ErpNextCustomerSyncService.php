<?php

namespace App\Services\CustomerSync;

use App\Models\User;
use App\Services\ErpNextService;
use Illuminate\Support\Facades\Log;

/**
 * Real ERPNext implementation of the customer-sync seam.
 *
 * Bound in AppServiceProvider only when services.erpnext.enabled is true and a
 * base URL is configured; otherwise NullCustomerSyncService is used. Every method
 * is defensive (try/catch + fail-open) so an ERP problem can never break the
 * website registration/profile flows that call this seam.
 */
class ErpNextCustomerSyncService implements CustomerSyncService
{
    public function __construct(protected ErpNextService $erp)
    {
    }

    /**
     * After a website/app registration: find-or-create the ERP customer and store
     * its id locally. Uses updateQuietly to avoid firing model events / activity logs.
     */
    public function onCustomerRegistered(User $user): void
    {
        try {
            // Already linked - nothing to do.
            if (!empty($user->erp_customer_id)) {
                return;
            }

            $erpCustomerId = $this->erp->findOrCreateCustomer($user);

            if ($erpCustomerId !== null) {
                $user->updateQuietly([
                    'erp_customer_id' => $erpCustomerId,
                    'synced_at' => now(),
                ]);
            }
        } catch (\Throwable $e) {
            Log::warning('ErpNextCustomerSync onCustomerRegistered failed: ' . $e->getMessage(), [
                'user_id' => $user->id,
            ]);
        }
    }

    /**
     * After a profile edit: push the changed details to ERP (best-effort).
     */
    public function pushProfileUpdate(User $user): void
    {
        try {
            if (empty($user->erp_customer_id)) {
                // Not linked yet - try to establish the link first.
                $this->onCustomerRegistered($user);

                return;
            }

            $this->erp->updateCustomer($user->erp_customer_id, [
                'customer_name' => $user->name,
                'customer_phone' => $user->phone,
            ]);

            $user->updateQuietly(['synced_at' => now()]);
        } catch (\Throwable $e) {
            Log::warning('ErpNextCustomerSync pushProfileUpdate failed: ' . $e->getMessage(), [
                'user_id' => $user->id,
            ]);
        }
    }
}
