<?php

namespace App\Services\CustomerSync;

use App\Models\User;
use Illuminate\Support\Facades\Log;

/**
 * No-op implementation used until the ERPNext integration sub-plan is executed.
 *
 * It intentionally does nothing beyond a debug log so registration works standalone.
 * Swap the container binding to the real ERP implementation later.
 */
class NullCustomerSyncService implements CustomerSyncService
{
    public function onCustomerRegistered(User $user): void
    {
        Log::debug('CustomerSync (noop) onCustomerRegistered', ['user_id' => $user->id]);
    }

    public function pushProfileUpdate(User $user): void
    {
        Log::debug('CustomerSync (noop) pushProfileUpdate', ['user_id' => $user->id]);
    }
}
