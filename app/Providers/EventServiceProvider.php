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
            'App\Listeners\Site\Config\Nginx',
            'App\Listeners\Site\Config\Homestead',
            'App\Listeners\Site\Finisher',
        ],
        'App\Events\SiteWasCloned' => [
            'App\Listeners\Site\Clones',
            'App\Listeners\Site\Composer',
            'App\Listeners\Site\Env',
            'App\Listeners\Site\Database',
            'App\Listeners\Site\Key',
            'App\Listeners\Site\Config\Nginx',
            'App\Listeners\Site\Config\Homestead',
            'App\Listeners\Site\Finisher',
        ],
        'App\Events\SiteWasInstalled' => [
            'App\Listeners\Site\Install',
            'App\Listeners\Site\Config\Nginx',
            'App\Listeners\Site\Config\Homestead',
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
