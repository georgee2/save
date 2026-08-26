<?php

namespace App\Support;

/**
 * Shared email validation for the public auth forms.
 *
 * The MX lookup behind `dns` is a blocking network call on unauthenticated, high-volume
 * endpoints, so it is kept for production only: outside it the check makes the test suite
 * depend on connectivity and on whichever domains happen to resolve, and it slows local
 * development for no security gain. `rfc` still applies everywhere.
 */
class EmailRules
{
    public static function format(): string
    {
        return app()->isProduction() ? 'email:rfc,dns' : 'email:rfc';
    }
}
