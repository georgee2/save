<?php

namespace App\Support;

/**
 * Result of a reCAPTCHA assessment.
 *
 * The distinction that matters is Failed vs Unavailable. Failed means Google answered and
 * the token was bad — block it. Unavailable means we could not reach Google at all, which
 * is our problem, not the visitor's; callers fail open and compensate with a stricter rate
 * limit rather than turning a Google outage into a site outage.
 */
enum RecaptchaOutcome
{
    /** Verified, and the score met the threshold. */
    case Passed;

    /** Google answered and rejected it, the score was too low, or the action did not match. */
    case Failed;

    /** Verification could not complete (timeout, DNS, non-2xx). Fail open, then throttle. */
    case Unavailable;

    /** No secret configured, or disabled for this environment. */
    case Disabled;
}
