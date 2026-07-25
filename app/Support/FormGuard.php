<?php

namespace App\Support;

use Illuminate\Http\Request;

/**
 * Shared honeypot + timing checks for the public forms.
 *
 * Replaces four hand-rolled copies that shared two weaknesses: the timestamp was a raw
 * client-supplied time() any bot could forge, and the check was written as
 * `if ($formLoaded > 0 && ...)`, so simply omitting the field skipped it entirely.
 *
 * The timestamp is now HMAC-signed with the app key. HMAC rather than encrypt() because
 * decrypt() throws on tampering and would need a try/catch at every call site, whereas
 * hash_equals just returns false.
 *
 * The signature is deliberately not bound to the session: a bot could load one page and
 * replay the token for MAX_AGE, but the CSRF token already has exactly that property and
 * is required on all of these forms, so binding would add nothing.
 *
 * Render the fields with @include('includes.form-guard').
 */
class FormGuard
{
    /**
     * Hidden field a human never sees and never fills. Named to look plausible to a bot
     * while not colliding with `website_url`, which is a real column on partners.
     */
    public const HONEYPOT = 'svec_ref_url';

    public const TIMESTAMP = '_form_ts';

    /** Submissions faster than this are automated. */
    public const MIN_SECONDS = 3;

    /** Signatures older than this are treated as a stale page, not a bot. */
    public const MAX_AGE = 86400;

    /**
     * Signed timestamp for the hidden field.
     *
     * $issuedAt exists so tests can mint a signature of a given age without duplicating
     * the signing format; leave it null everywhere else.
     */
    public static function signature(?int $issuedAt = null): string
    {
        $issued = $issuedAt ?? time();

        return $issued . '|' . hash_hmac('sha256', (string) $issued, config('app.key'));
    }

    /**
     * Why this submission should be rejected, or null if it looks human.
     */
    public static function tripped(Request $request): ?FormGuardReason
    {
        if ($request->filled(self::HONEYPOT)) {
            return FormGuardReason::Honeypot;
        }

        $issued = self::verifiedTimestamp($request->input(self::TIMESTAMP));

        // Missing or forged: a bot that omitted the field, or a page rendered before this
        // guard shipped. Either way we cannot vouch for the age.
        if ($issued === null) {
            return FormGuardReason::Stale;
        }

        $age = time() - $issued;

        if ($age < self::MIN_SECONDS) {
            return FormGuardReason::TooFast;
        }

        if ($age > self::MAX_AGE) {
            return FormGuardReason::Stale;
        }

        return null;
    }

    /**
     * Recover the issue time from a signature, or null if it does not verify.
     */
    private static function verifiedTimestamp($value): ?int
    {
        if (!is_string($value) || !str_contains($value, '|')) {
            return null;
        }

        [$issued, $digest] = explode('|', $value, 2);

        if ($issued === '' || !ctype_digit($issued)) {
            return null;
        }

        $expected = hash_hmac('sha256', $issued, config('app.key'));

        if (!hash_equals($expected, $digest)) {
            return null;
        }

        return (int) $issued;
    }
}
