<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rules\Password;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


use App\Models\Service;
use App\Models\About;
use App\Models\ProjectType;
use App\Models\ContactInfo;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Schema::defaultStringLength(191);

        // ERP seam: bind the real ERPNext implementation only when the integration
        // is explicitly enabled AND a base URL is configured; otherwise stay on the
        // no-op service. This keeps the site fully functional (and free of ERP
        // errors) until the ERP team has delivered and the flag is flipped.
        $erpReady = config('services.erpnext.enabled') && config('services.erpnext.base_url');
        $this->app->bind(
            \App\Services\CustomerSync\CustomerSyncService::class,
            $erpReady
                ? \App\Services\CustomerSync\ErpNextCustomerSyncService::class
                : \App\Services\CustomerSync\NullCustomerSyncService::class
        );

        //Get Service
        $this->app->singleton('Service', function () {
            $Service = new Service;
            return $Service->serviceshome();
        });


        //Get About
        $this->app->singleton('About', function () {
            $About = new About;
            return $About->find(1);
        });

        //Get Category
        $this->app->singleton('ProjectType', function () {
            $ProjectType = new ProjectType;
            return $ProjectType->gettypes();
        });

        $this->app->singleton('Contact', function () {
            $ContactInfo = new ContactInfo;
            return $ContactInfo->list();

        });


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force absolute URLs (sitemap, mails, CLI-generated links) to HTTPS when the
        // canonical app URL is HTTPS, so they never emit http:// regardless of request context.
        if (str_starts_with((string) config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }

        // Register Header Composer for all views
        view()->composer('*', \App\Http\View\Composers\HeaderComposer::class);

        // Shared customer password policy: at least 8 chars with mixed case and a number.
        // Reused via Password::defaults() at set-password / change-password.
        Password::defaults(fn () => Password::min(8)->mixedCase()->numbers());
    }
}
