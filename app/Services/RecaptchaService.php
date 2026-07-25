<?php

namespace App\Services;

use App\Support\RecaptchaOutcome;
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
     * Assess a reCAPTCHA token.
     *
     * Named check() rather than verify() deliberately. This used to return a bool and
     * every call site read `!$this->recaptcha->verify(...)`. Since `!` on any object —
     * including an enum case — is false, a call site left on the old API would have
     * silently stopped blocking anything, and nothing would have caught it: there is no
     * static analysis here, and isEnabled() returns false in both local and testing. The
     * rename makes a missed call site throw instead.
     *
     * @param  string|array<int,string>  $expectedAction  action(s) the token may carry.
     *                                                    Pass several when more than one
     *                                                    form posts to the same route.
     */
    public function check(
        ?string $token,
        string|array $expectedAction,
        ?string $remoteIp = null,
        ?float $minScore = null
    ): RecaptchaOutcome {
        // Covers both an unconfigured secret and the local environment, so call sites do
        // not have to remember to gate on isEnabled() themselves.
        if (!$this->isEnabled()) {
            return RecaptchaOutcome::Disabled;
        }

        $secret = config('services.recaptcha.secret_key');

        // A missing token is a failure, never Unavailable — otherwise a bot omits the
        // token to reach the lenient fail-open branch.
        if (empty($token)) {
            return RecaptchaOutcome::Failed;
        }

        try {
            // Timeout but no retry: we fail open on Unavailable anyway, so a second attempt
            // would only double the worst-case wait a visitor sits through on a public form.
            $response = Http::timeout(3)
                ->asForm()
                ->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => $secret,
                    'response' => $token,
                    'remoteip' => $remoteIp ?? request()->ip(),
                ]);

            if (!$response->successful()) {
                Log::error('reCAPTCHA siteverify returned HTTP ' . $response->status());

                return RecaptchaOutcome::Unavailable;
            }

            $data = $response->json();
        } catch (\Throwable $e) {
            // Network/DNS/timeout. Logged at error, not warning: this silently disables a
            // control, so it needs to be visible in the logs.
            Log::error('reCAPTCHA verification unavailable: ' . $e->getMessage());

            return RecaptchaOutcome::Unavailable;
        }

        if (!($data['success'] ?? false)) {
            return RecaptchaOutcome::Failed;
        }

        // Bind the token to the form it was minted for, so a token harvested from one
        // page cannot be replayed against another.
        $allowed = (array) $expectedAction;
        if (!in_array($data['action'] ?? '', $allowed, true)) {
            Log::warning('reCAPTCHA action mismatch: got ' . ($data['action'] ?? 'none'));

            return RecaptchaOutcome::Failed;
        }

        // Not enforced: site keys are already domain-bound at Google, and LaravelLocalization
        // prefixes plus staging hosts make a strict check brittle. Logged so a genuine
        // cross-site replay is still visible.
        $expectedHost = parse_url((string) config('app.url'), PHP_URL_HOST);
        if ($expectedHost && isset($data['hostname']) && $data['hostname'] !== $expectedHost) {
            Log::warning("reCAPTCHA hostname mismatch: got {$data['hostname']}, expected {$expectedHost}");
        }

        $minScore = $minScore ?? (float) config('services.recaptcha.min_score', 0.5);

        return ($data['score'] ?? 0) >= $minScore
            ? RecaptchaOutcome::Passed
            : RecaptchaOutcome::Failed;
    }
}
