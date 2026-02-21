<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blade::if('permission', function (string $permission) {
            $user = Auth::user();
            return $user && $user->hasPermission($permission);
        });

        Blade::if('anypermission', function (array $permissions) {
            $user = Auth::user();
            return $user && $user->hasAnyPermission($permissions);
        });

        Blade::if('role', function (string $role) {
            $user = Auth::user();
            return $user && $user->hasRole($role);
        });

        Blade::if('anyrole', function (array $roles) {
            $user = Auth::user();
            return $user && $user->hasAnyRole($roles);
        });

        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $view->with('userPermissions', $user->getPermissionSlugs());
                $view->with('isSuperAdmin', $user->isSuperAdmin());
            } else {
                $view->with('userPermissions', []);
                $view->with('isSuperAdmin', false);
            }
        });
    }
}
