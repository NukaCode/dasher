<?php

namespace App\Listeners\Site;

use App\Events\Event;
use App\Models\Group;
use App\Services\Envoy;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;

class Install implements ShouldQueue
{

    /**
     * @var Group
     */
    private $group;

    /**
     * @var Envoy
     */
    private $envoy;

    /**
     * @param Group $group
     * @param Envoy $envoy
     */
    public function __construct(Group $group, Envoy $envoy)
    {
        $this->group = $group;
        $this->envoy = $envoy;
    }

    /**
     * @param Event $event
     */
    public function handle(Event $event)
    {
        $event->site->updateStatus('Running the installer');

        $installerType = $event->request['installType'] == 'base' ? null : '"--' . $event->request['installType'] . '"';
        $group         = $this->group->find($event->request['group_id']);
        $sitePath      = Str::camel($event->request['name']);

        $this->envoy->run('make-site --path="' . $group->starting_path . '" --name="' . $sitePath . '" --type=' . $installerType, true);
    }
}