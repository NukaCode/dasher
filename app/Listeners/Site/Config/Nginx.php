<?php

namespace App\Listeners\Site\Config;

use App\Events\Event;
use App\Resources\Nginx as NginxResource;
use App\Services\Envoy;
use Illuminate\Contracts\Queue\ShouldQueue;

class Nginx implements ShouldQueue
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
        // Make sure it's an nginx site
        if (settingEnabled('nginx') && $event->site->homesteadFlag == 0) {
            $this->createConfig($event->site);
            $this->reloadNginx($event->site);
        }
    }

    protected function createConfig($site)
    {
        $site->updateStatus('Setting up nginx');

        NginxResource::createConfig($site);
    }

    protected function reloadNginx($site)
    {
        $site->updateStatus('Reloading nginx');

        $this->envoy->run('nginx --cmd="reload"');
    }
}
