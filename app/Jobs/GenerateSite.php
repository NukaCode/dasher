<?php

namespace App\Jobs;

use App\Events\SiteWasGenerated;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GenerateSite extends Job implements SelfHandling, ShouldQueue
{

    use InteractsWithQueue;

    /**
     * @var
     */
    private $site;

    /**
     * @var array
     */
    private $request;

    /**
     * Create a new job instance.
     *
     * @param array $request
     */
    public function __construct($site, array $request)
    {
        $this->site    = $site;
        $this->request = $request;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        event(new SiteWasGenerated($this->site, $this->request));
    }
}
