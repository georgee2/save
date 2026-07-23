<?php

namespace App\Listeners;

use App\Services\FavouriteMergeService;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Log;

/**
 * On every login (covers LoginController@checkuser and the set-password
 * auto-login), fold the current browser's guest favourites into the customer's
 * account. Gated to customers; failures are logged, never fatal to the login.
 */
class MergeGuestFavouritesIntoAccount
{
    public function __construct(protected FavouriteMergeService $merger)
    {
    }

    public function handle(Login $event): void
    {
        $user = $event->user;

        if (!method_exists($user, 'isCustomer') || !$user->isCustomer()) {
            return;
        }

        try {
            $guestId = request()->cookie('favourite_session_id') ?: session('favourite_session_id');
            $this->merger->mergeGuestIntoAccount($user, $guestId);
        } catch (\Throwable $e) {
            Log::warning('Favourite merge on login failed: ' . $e->getMessage());
        }
    }
}
