<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Site;
use App\Services\Site\Generate;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;

class GenerateSite extends Job implements SelfHandling, ShouldQueue
{

    use InteractsWithQueue;

    /**
     * @var array
     */
    private $request;

    /**
     * Create a new job instance.
     *
     * @param array $request
     */
    public function __construct(array $request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Add Site to DB
        app(Generate::class)->handle($this->request);
    }
}
