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
     * Create a new event instance.
     *
     * @param Site $site
     */
    public function __construct(Site $site)
    {
        $this->site = $site;
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
