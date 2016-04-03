<?php

namespace EmergencyExplorer\Providers;

use Carbon\Carbon;
use EmergencyExplorer\Http\View\Helper\NavigationHelper;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale(config('app.locale'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->singleton(NavigationHelper::class, function() {
            return new NavigationHelper();
        });
    }
}
