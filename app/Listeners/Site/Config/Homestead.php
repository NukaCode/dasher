<?php

namespace App\Listeners\Site\Config;

use App\Events\Event;
use App\Resources\Homestead as HomesteadResource;
use App\Resources\Hosts;
use App\Services\Envoy;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class Homestead implements ShouldQueue
{

    /**
     * @var Envoy
     */
    private $envoy;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * Create the event listener.
     *
     * @param Envoy      $envoy
     * @param Filesystem $filesystem
     */
    public function __construct(Envoy $envoy, Filesystem $filesystem)
    {
        $this->envoy      = $envoy;
        $this->filesystem = $filesystem;
    }

    /**
     * Handle the event.
     *
     * @param Event $event
     */
    public function handle(Event $event)
    {
        try {
            // Make sure it's an nginx site
            if (settingEnabled('homestead') && $event->site->homesteadFlag == 1) {
                $this->createConfig($event->site);
                $this->addEnv($event->site);
                $this->provisionVagrant($event->site);
                $this->addHost($event->site);
            }
        } catch (\Exception $exception) {
            $event->site->updateStatus($exception->getMessage());
        }
    }

    protected function createConfig($site)
    {
        $site->updateStatus('Setting up homestead');

        app(HomesteadResource::class)->createConfig($site);
    }

    protected function addEnv($site)
    {
        $site->updateStatus('Adding .env to site');

        // Get the config template
        $template = $this->filesystem->get(base_path('resources/templates/.env.template'));

        // Replace the needed data
        $config = str_replace(['{{DATABASE}}'], [Str::snake($site->name)], $template);

        // Save the config to the filesystem.
        $filename = str_replace('public', '', $site->path) . '.env';

        $this->filesystem->put($filename, $config);
    }

    protected function provisionVagrant($site)
    {
        $site->updateStatus('Re-provisioning vagrant box');

        $this->envoy->run('vagrant --cmd="provision" --path="' . setting('homestead') . '"');
    }

    protected function addHost($site)
    {
        $site->updateStatus('Adding host to /etc/hosts');

        app(Hosts::class)->addHost(Str::snake($site->name) . '.app');
    }
}
