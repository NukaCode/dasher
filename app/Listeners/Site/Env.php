<?php

namespace App\Listeners\Site;

use App\Events\Event;
use App\Services\Envoy;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class Env implements ShouldQueue
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
        $event->site->updateStatus('Adding .env to site');

        // Get the config template
        $template = $this->filesystem->get(base_path('resources/templates/.env.template'));

        // Replace the needed data
        $config = str_replace(['{{DATABASE}}'], [Str::snake($event->site->name)], $template);

        // Save the config to the filesystem.
        $filename = preg_replace('{/$}', '', $event->site->rootPath) . '/.env';

        $this->filesystem->put($filename, $config);
    }

}
