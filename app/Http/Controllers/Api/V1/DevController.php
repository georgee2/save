<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

/**
 * Local-only testing helper. Its route is registered ONLY when APP_ENV=local
 * (see routes/api.php) - it does not exist at all outside local, so there is no
 * way to reach it in production even if this file is left in place.
 */
class DevController extends Controller
{
    /**
     * Clear the rate-limit/cooldown cache keys for one email, so register/login/
     * forgot-password/resend-activation can be retested immediately from a REST
     * client without waiting out the real windows or running `cache:clear`.
     */
    public function resetThrottle(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = Str::lower(trim($request->email));
        $ip = $request->ip();

        $keys = [
            'api-register:'.$email,
            'api-login:'.$email.'|'.$ip,
            'pwreset-cooldown:'.$email,
            'invite-cooldown:'.$email,
        ];

        RateLimiter::clear($keys[0]);
        RateLimiter::clear($keys[1]);
        Cache::forget($keys[2]);
        Cache::forget($keys[3]);

        return response()->json([
            'success' => true,
            'message' => 'Throttle/cooldown keys cleared for '.$email,
            'cleared_keys' => $keys,
        ]);
    }
}
