<?php

namespace App\Providers;

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
        'App\Events\SiteWasCreated' => [
            'App\Listeners\Site\GenerateNginxConfig',
            'App\Listeners\Site\GenerateHomesteadConfig',
            'App\Listeners\Site\Finisher',
        ],
        'App\Events\SiteWasGenerated' => [
            'App\Listeners\Site\LaravelInstaller',
            'App\Listeners\Site\GenerateNginxConfig',
            'App\Listeners\Site\GenerateHomesteadConfig',
            'App\Listeners\Site\Finisher',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
