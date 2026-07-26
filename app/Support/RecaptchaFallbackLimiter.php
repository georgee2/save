<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

/**
 * Compensating rate limit for when reCAPTCHA could not be verified.
 *
 * When Google is unreachable the forms fail open, so a Google outage never becomes an
 * SVEC outage. That would otherwise hand an attacker a free bypass by simply making
 * verification fail, so any IP taking the fail-open path drops to a much stricter budget
 * than the route throttle allows.
 *
 * Anonymous forms only. Login deliberately does not use this: reCAPTCHA there is a step-up
 * after repeated failures, and pushing staff who mistype into a hard lockout during a
 * Google outage would be self-inflicted. Login already has two limiters of its own.
 */
class RecaptchaFallbackLimiter
{
    /** Submissions allowed per window while verification is degraded. */
    public const MAX_ATTEMPTS = 2;

    public const DECAY_SECONDS = 3600;

    /**
     * Record a degraded submission and report whether this IP has now exhausted its budget.
     */
    public static function exceeded(Request $request, string $scope): bool
    {
        $key = 'recaptcha-degraded:' . $scope . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, self::MAX_ATTEMPTS)) {
            return true;
        }

        RateLimiter::hit($key, self::DECAY_SECONDS);

        return false;
    }
}
