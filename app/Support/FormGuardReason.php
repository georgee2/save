<?php

namespace App\Support;

/**
 * Why FormGuard rejected a submission.
 *
 * Honeypot and TooFast indicate a bot: callers should return their normal success
 * response so the bot learns nothing about the trap. Stale means the signed timestamp
 * was missing, forged, or expired — that is usually a real person on a page that was
 * open too long, so callers should show a visible "refresh and resubmit" message
 * rather than a silent fake success that loses their message.
 */
enum FormGuardReason
{
    case Honeypot;
    case TooFast;
    case Stale;

    /**
     * Whether the caller should respond with its silent success path.
     */
    public function isBot(): bool
    {
        return $this !== self::Stale;
    }
}
