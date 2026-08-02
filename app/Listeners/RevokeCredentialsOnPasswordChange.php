<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

/**
 * Invalidates everything that could still get into an account after its password changes.
 *
 * Before this, changing a password revoked nothing: outstanding reset links stayed valid
 * for up to 60 minutes and invitation links for up to 48 hours, and Sanctum tokens never
 * expired at all. A user reacting to a compromise by changing their password did not
 * actually lock the attacker out - they could replay a link or a token they already held.
 *
 * Hangs off PasswordReset so every path is covered by one piece of code. The self-service
 * change-password flows did not fire that event, so they now do.
 *
 * Note: evicting other *browser sessions* is not done here. That needs the plaintext
 * password for Auth::logoutOtherDevices(), which an event listener does not have, so it
 * stays in the controllers.
 */
class RevokeCredentialsOnPasswordChange
{
    public function handle(PasswordReset $event): void
    {
        $user = $event->user;

        if (!$user instanceof User) {
            return;
        }

        // Both brokers: the customer set-password endpoint consumes either, so consuming
        // one previously left the other's token live.
        Password::broker()->deleteToken($user);
        Password::broker('invitations')->deleteToken($user);

        // Kills every issued API bearer token. They have no expiry, so without this a
        // stolen token outlives the password it was obtained with.
        $user->tokens()->delete();

        // Invalidates any remember-me cookie, and abandons a half-finished email change:
        // whoever started it may be the person being locked out.
        $user->forceFill([
            'remember_token' => Str::random(60),
            'pending_email' => null,
            'pending_email_token' => null,
        ])->saveQuietly();
    }
}
