<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // Analytics heartbeat. Keyed on the visitor cookie rather than the IP: the beacon
        // fires every 30 seconds per open tab, so an IP-keyed limit would throttle a whole
        // office behind one NAT and silently lose their analytics — sendBeacon is
        // fire-and-forget, so nothing would surface the 429. Falls back to the IP only for
        // requests with no cookie, which the endpoint rejects anyway.
        RateLimiter::for('heartbeat', function (Request $request) {
            return Limit::perMinute(30)->by($request->cookie('svec_vid') ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
