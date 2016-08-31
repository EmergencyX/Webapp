<?php

namespace EmergencyExplorer\Providers;

use Carbon\Carbon;
use EmergencyExplorer\Http\View\Helper\NavigationHelper;
use Illuminate\Pagination\BootstrapFourPresenter;
use Illuminate\Pagination\Paginator;
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

        /*Paginator::presenter(function($paginator) {
            return new BootstrapFourPresenter($paginator);
        });*/
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path('Util/Helper.php');

        app()->singleton(NavigationHelper::class, function() {
            return new NavigationHelper();
        });
    }
}
