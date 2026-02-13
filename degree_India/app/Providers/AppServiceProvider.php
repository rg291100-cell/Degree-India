<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;
use App\Services\CurrentsAPIService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
   public function register()
    {
        $this->app->bind(CurrentsAPIService::class, function ($app) {
            return new CurrentsAPIService();
        });
    }
    

    public function boot()
    {
        Schema::defaultStringLength(191);
        // Custom Blade directive for permissions
        Blade::if('hasPermission', function ($permission) {
            return auth()->check() && auth()->user()->hasPermission($permission);
        });

        // Check multiple permissions
        Blade::if('hasAnyPermission', function ($permissions) {
            return auth()->check() && auth()->user()->hasAnyPermission($permissions);
        });
    }
}
