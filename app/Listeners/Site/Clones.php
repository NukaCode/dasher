<?php

namespace App\Listeners\Site;

use App\Events\Event;
use App\Models\Clones as CloneModel;
use App\Models\Group;
use App\Services\Envoy;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;

class Clones implements ShouldQueue
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
     * @var CloneModel
     */
    private $clone;

    /**
     * @param Group      $group
     * @param Envoy      $envoy
     * @param CloneModel $clone
     */
    public function __construct(Group $group, Envoy $envoy, CloneModel $clone)
    {
        $this->group = $group;
        $this->envoy = $envoy;
        $this->clone = $clone;
    }

    /**
     * @param Event $event
     */
    public function handle(Event $event)
    {
        $cloneModel = $this->clone->find($event->request['clone_id']);
        $group      = $this->group->find($event->request['group_id']);
        $sitePath   = Str::camel($event->request['name']);

        $event->site->updateStatus('Cloning the repo');

        $this->envoy->run('clone --path="' . $group->starting_path . '" --name="' . $sitePath . '" --url=' . $cloneModel->url, true);
    }

}
