<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Reusable Google reCAPTCHA v3 verification. Config-gated: verification is only
 * enforced when a secret key is configured (config/services.php -> recaptcha).
 */
class RecaptchaService
{
    /**
     * Whether reCAPTCHA should be enforced. Requires a configured secret key and
     * is skipped in the local environment (the site key is domain-bound to the
     * production host, so it cannot validate on localhost during development).
     */
    public function isEnabled(): bool
    {
        if (app()->environment('local')) {
            return false;
        }

        return !empty(config('services.recaptcha.secret_key'));
    }

    /**
     * Verify a reCAPTCHA v3 token against Google, honoring the configured min score.
     *
     * Fails open on network/exception errors (so a Google outage never blocks
     * legitimate signups), but returns false on a genuine failed verification.
     */
    public function verify(?string $token, ?string $remoteIp = null): bool
    {
        $secret = config('services.recaptcha.secret_key');

        // Not configured -> nothing to verify; treat as passing.
        if (empty($secret)) {
            return true;
        }

        if (empty($token)) {
            return false;
        }

        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secret,
                'response' => $token,
                'remoteip' => $remoteIp ?? request()->ip(),
            ]);

            $data = $response->json();
            $minScore = (float) config('services.recaptcha.min_score', 0.5);

            return ($data['success'] ?? false) && ($data['score'] ?? 0) >= $minScore;
        } catch (\Throwable $e) {
            Log::warning('reCAPTCHA verification failed: ' . $e->getMessage());

            return true;
        }
    }
}
