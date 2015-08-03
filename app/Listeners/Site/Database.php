<?php

namespace App\Listeners\Site;

use App\Events\Event;
use App\Services\Envoy;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;

class Database implements ShouldQueue
{

    /**
     * @var Envoy
     */
    private $envoy;

    /**
     * Create the event listener.
     *
     * @param Envoy $envoy
     */
    public function __construct(Envoy $envoy)
    {
        $this->envoy = $envoy;
    }

    /**
     * Handle the event.
     *
     * @param Event $event
     */
    public function handle(Event $event)
    {
        $event->site->updateStatus('Adding mysql database');

        $sql = 'CREATE DATABASE IF NOT EXISTS ' . Str::snake($event->site->name) . ';';

        $this->envoy->run('mysql --sql="' . $sql . '"', true);
        $this->envoy->run('artisan --path="' . $event->site->rootPath . '" --cmd="migrate"', true);
    }

}
