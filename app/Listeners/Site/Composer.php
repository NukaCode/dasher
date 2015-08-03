<?php

namespace App\Listeners\Site;

use App\Events\Event;
use App\Services\Envoy;
use Illuminate\Contracts\Queue\ShouldQueue;

class Composer implements ShouldQueue
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
        $event->site->updateStatus('Running composer install');

        $this->envoy->run('composer --path="' . $event->site->rootPath . '" --cmd=install', true);
    }

}
