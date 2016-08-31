<?php

namespace EmergencyExplorer\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'EmergencyExplorer\Events\SomeEvent' => [
            'EmergencyExplorer\Listeners\EventListener',
        ],
    ];
    
    /**
     *
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
