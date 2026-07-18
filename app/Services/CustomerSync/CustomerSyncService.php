<?php

namespace App\Services\CustomerSync;

use App\Models\User;

/**
 * Seam for the ERPNext integration.
 *
 * Registration and profile code depend only on this interface. Bound to
 * NullCustomerSyncService while ERPNEXT_ENABLED is false; when the flag and
 * base URL are set, AppServiceProvider binds ErpNextCustomerSyncService
 * instead - no controller changes required.
 */
interface CustomerSyncService
{
    /**
     * Called after a customer account is created on the website/app.
     * Later: ERP find-or-create + store erp_customer_id on the user.
     */
    public function onCustomerRegistered(User $user): void;

    /**
     * Called after a customer edits their profile details.
     * Later: push the changes to ERP.
     */
    public function pushProfileUpdate(User $user): void;
}
