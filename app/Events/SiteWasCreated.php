<?php

namespace App\Events;

use App\Models\Site;

class SiteWasCreated extends Event
{

    /**
     * @var Site
     */
    public $site;

    /**
     * @var Request
     */
    public $request;

    /**
     * Create a new event instance.
     *
     * @param Site  $site
     * @param array $request
     */
    public function __construct(Site $site, array $request)
    {
        $this->site    = $site;
        $this->request = $request;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
