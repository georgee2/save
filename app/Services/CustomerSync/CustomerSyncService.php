<?php

namespace App\Services\CustomerSync;

use App\Models\User;

/**
 * Seam for the (deferred) ERPNext integration.
 *
 * Registration and profile code depend only on this interface. Today it is bound to
 * NullCustomerSyncService (a no-op). When the ERP sub-plan lands, bind an
 * ErpNextCustomerSyncService instead - no controller changes required.
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
