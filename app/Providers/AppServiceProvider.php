<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        // Register Header Composer for all views
        view()->composer('*', \App\Http\View\Composers\HeaderComposer::class);
    }
}
