<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array<int, string>
     */
    /**
     * `favourite_session_id` used to be listed here. It is the authorization key for every
     * favourites operation, and the share URL publishes its value, so leaving it unencrypted
     * let anyone who received a shared link set the cookie and read, delete, or overwrite the
     * owner's list. Encryption makes it unforgeable. Nothing reads it from JavaScript.
     */
    protected $except = [
        //
    ];
}
