<?php

namespace App\Support;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Evens out the response time of paths that would otherwise reveal whether an account
 * exists.
 *
 * bcrypt at the configured cost dominates these requests. When an address has no account
 * the expensive work is skipped entirely - Auth::attempt never reaches Hash::check, and
 * forgot-password never reaches the hash inside createToken - so an unknown address
 * answers measurably faster than a known one. The generic error message is uniform, but
 * the latency is not, and latency is enough to enumerate a user list.
 */
class TimingGuard
{
    /**
     * Spend roughly the same time one real password verification would.
     *
     * Call this on the branch that skipped the hashing, not on the branch that did it.
     */
    public static function burnPasswordHash(): void
    {
        Hash::make(Str::random(40));
    }
}
