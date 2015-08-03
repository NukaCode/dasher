<?php

namespace App\Listeners\Site;

use App\Events\Event;
use App\Services\Envoy;
use Illuminate\Contracts\Queue\ShouldQueue;

class Key implements ShouldQueue
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
        $event->site->updateStatus('Generating key');

        $this->envoy->run('artisan --path="' . $event->site->rootPath . '" --cmd="key:generate"', true);
    }

}
