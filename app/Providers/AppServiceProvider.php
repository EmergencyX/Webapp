<?php

namespace EmergencyExplorer\Providers;

use Carbon\Carbon;
use EmergencyExplorer\Http\View\Composers\ImageComposer;
use EmergencyExplorer\Http\View\Composers\ProjectComposer;
use EmergencyExplorer\Http\View\Composers\UserComposer;
use EmergencyExplorer\Http\View\Helper\NavigationHelper;
use EmergencyExplorer\Rules\Semver;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

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

        Passport::routes();

        Passport::enableImplicitGrant();

        app()->singleton(NavigationHelper::class, function () {
            return new NavigationHelper();
        });

        \View::composer('*', ProjectComposer::class);
        \View::composer('*', ImageComposer::class);
        \View::composer('*', UserComposer::class);

        \Validator::extend('semver', Semver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path('Util/helper.php');
    }
}
