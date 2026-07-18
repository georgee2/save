<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Rejects email addresses that use a known disposable/throwaway provider domain.
 * The blocklist lives in config/disposable_email_domains.php (curated, not
 * exhaustive) and is intended as a lightweight spam deterrent layered on top of
 * MX validation and reCAPTCHA.
 */
class DisposableEmail implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value) || !str_contains($value, '@')) {
            return;
        }

        $domain = strtolower(trim(substr(strrchr($value, '@'), 1)));

        if ($domain === '') {
            return;
        }

        $blocked = array_map('strtolower', (array) config('disposable_email_domains', []));

        if (in_array($domain, $blocked, true)) {
            $fail('Please use a permanent, non-disposable email address.');
        }
    }
}
