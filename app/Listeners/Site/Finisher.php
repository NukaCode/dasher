<?php

namespace App\Listeners\Site;

use App\Events\Event;
use Illuminate\Contracts\Queue\ShouldQueue;

class Finisher implements ShouldQueue
{

    /**
     * Handle the event.
     *
     * @param Event $event
     */
    public function handle(Event $event)
    {
        $event->site->updateStatus('Complete', true);
    }
}
