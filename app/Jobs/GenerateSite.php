<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class GenerateSite extends Job implements SelfHandling
{
    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Add Site to DB
        // Trigger create for nginx/homestead
        // Update DB as it generate
        // Have vue look for status when readyFlag is 0

        // Statuses Nginx
        // Setting up
        // Running installer
        // Finishing up

        // Statuses Homestead
        // Setting up
        // Running installer
        // Reprovisioning vagrant
        // Finishing up
    }
}
