<?php

namespace App\Support;

use App\Mail\AccountLockedMail;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

/**
 * Per-account brute-force ceiling, shared by the web and API login paths.
 *
 * Every pre-existing limiter keyed on the IP (`login|email|ip`, `login-ip|ip`,
 * `api-login:email|ip`), so a single account had no aggregate cap: an attacker rotating
 * IPs got the full per-IP budget again from each one, unbounded in total. This adds the
 * missing dimension - a budget for the account itself, regardless of where attempts come
 * from - plus a durable lockout, because the rate limiter lives in the cache and a deploy
 * or cache flush would otherwise reset an attack in progress.
 *
 * Enumeration: the limiter is keyed on the submitted address and is hit whether or not
 * that address has an account, so a locked response reveals nothing about existence.
 * Callers must return their usual generic credentials message, never a distinct one.
 */
class LoginThrottle
{
    /** Failed attempts allowed per account per window, across all IPs. */
    public const MAX_ATTEMPTS = 20;

    /** Rolling window for the above, in seconds. */
    public const WINDOW = 3600;

    /** How long the durable lockout lasts once the ceiling is hit. */
    public const LOCKOUT_MINUTES = 30;

    public static function key(string $email): string
    {
        return 'login-acct|' . Str::lower(trim($email));
    }

    /**
     * Is this account currently barred from attempting a login?
     */
    public static function locked(string $email, ?User $user = null): bool
    {
        if (RateLimiter::tooManyAttempts(self::key($email), self::MAX_ATTEMPTS)) {
            return true;
        }

        // Durable backstop: survives a cache flush mid-attack.
        return $user !== null && $user->isLockedOut();
    }

    /**
     * Seconds until the account may try again, for the caller's message.
     */
    public static function availableIn(string $email, ?User $user = null): int
    {
        $fromLimiter = RateLimiter::availableIn(self::key($email));

        $fromLock = ($user !== null && $user->isLockedOut())
            ? now()->diffInSeconds($user->locked_until)
            : 0;

        return max($fromLimiter, $fromLock, 1);
    }

    /**
     * Record a failed attempt and, if the ceiling is reached, lock the account.
     */
    public static function recordFailure(string $email, ?User $user = null): void
    {
        RateLimiter::hit(self::key($email), self::WINDOW);

        if (!RateLimiter::tooManyAttempts(self::key($email), self::MAX_ATTEMPTS)) {
            return;
        }

        if ($user === null) {
            return;
        }

        // saveQuietly: User uses the LogsActivity trait, and a normal save here would write
        // an `update` row to activity_logs on every locked attempt.
        $user->forceFill(['locked_until' => now()->addMinutes(self::LOCKOUT_MINUTES)])->saveQuietly();

        self::notifyOwner($user);
    }

    /**
     * Clear the account budget after a successful login.
     */
    public static function clear(string $email, ?User $user = null): void
    {
        RateLimiter::clear(self::key($email));

        if ($user !== null && $user->locked_until !== null) {
            $user->forceFill(['locked_until' => null])->saveQuietly();
        }
    }

    /**
     * Tell the account owner someone is attacking their account.
     *
     * Capped at one mail per lockout window so this cannot itself be used to flood a
     * victim's inbox by deliberately tripping the lock over and over.
     */
    private static function notifyOwner(User $user): void
    {
        $cooldown = 'lockout-notice:' . Str::lower($user->email);

        if (!Cache::add($cooldown, true, self::LOCKOUT_MINUTES * 60)) {
            return;
        }

        // afterResponse, matching the rest of the app: there is no queue worker.
        dispatch(function () use ($user) {
            try {
                Mail::to($user->email)->send(new AccountLockedMail($user, self::LOCKOUT_MINUTES));
            } catch (\Throwable $e) {
                Log::warning('Account lockout notice failed: ' . $e->getMessage());
            }
        })->afterResponse();
    }
}
