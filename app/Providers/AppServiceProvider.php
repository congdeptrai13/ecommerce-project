<?php

namespace App\Providers;

use App\Models\GeneralSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Paginator::useBootstrap();

        $generalSetting = GeneralSetting::first();

        //set timezone
        Config::set('app.timezone', $generalSetting->timezone);

        //share variable at all view
        View::composer("*", function ($view) use ($generalSetting) {
            $view->with('settings', $generalSetting);
        });
    }
}
