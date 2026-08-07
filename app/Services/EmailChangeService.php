<?php

namespace App\Services;

use App\Mail\CustomerEmailChangeMail;
use App\Mail\EmailChangeAlertMail;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

/**
 * Starting and completing a change of account email address.
 *
 * The web and API controllers each had their own copy of this, which had already drifted,
 * and both shared the same problems: the token was stored in plaintext, it had no
 * server-side expiry (only the signed URL expired, so the stored token stayed usable
 * against the database forever), and the address losing control of the account was never
 * told it was happening.
 */
class EmailChangeService
{
    /** How long a pending change stays confirmable. Matches the signed URL. */
    public const TTL_HOURS = 24;

    /**
     * Begin a change: store the hashed token, mail the new address a confirmation link,
     * and warn the old address.
     */
    public function start(User $user, string $newEmail): void
    {
        $token = Str::random(64);
        $previousEmail = $user->email;

        $user->forceFill([
            'pending_email' => $newEmail,
            // Hashed: a database leak should not hand over a working confirmation.
            'pending_email_token' => hash('sha256', $token),
            'pending_email_expires_at' => now()->addHours(self::TTL_HOURS),
        ])->save();

        $url = URL::temporarySignedRoute(
            'account.email.verify',
            now()->addHours(self::TTL_HOURS),
            ['token' => $token]
        );

        // afterResponse rather than inline: this is reached from a user-facing form and
        // there is no queue worker. Matches CustomerRegistrationService::sendInvite.
        dispatch(function () use ($user, $url, $newEmail, $previousEmail) {
            try {
                Mail::to($newEmail)->send(new CustomerEmailChangeMail($user, $url, $newEmail));
            } catch (\Throwable $e) {
                Log::warning('Email-change verification mail failed: ' . $e->getMessage());
            }

            // The old address is the one losing access, so it is the one that needs to know.
            try {
                Mail::to($previousEmail)->send(new EmailChangeAlertMail($user, $newEmail));
            } catch (\Throwable $e) {
                Log::warning('Email-change alert to the previous address failed: ' . $e->getMessage());
            }
        })->afterResponse();
    }

    /**
     * Complete a change if the token matches and has not expired.
     */
    public function confirm(User $user, string $token): bool
    {
        if (!$user->pending_email || !$user->pending_email_token) {
            return false;
        }

        if ($user->pending_email_expires_at === null || $user->pending_email_expires_at->isPast()) {
            return false;
        }

        if (!hash_equals($user->pending_email_token, hash('sha256', $token))) {
            return false;
        }

        // Someone else may have claimed the address while this was pending.
        $taken = User::where('email', $user->pending_email)
            ->where('id', '!=', $user->id)
            ->exists();

        if ($taken) {
            return false;
        }

        $user->forceFill([
            'email' => $user->pending_email,
            'email_verified_at' => now(),
            'pending_email' => null,
            'pending_email_token' => null,
            'pending_email_expires_at' => null,
        ])->save();

        return true;
    }
}
