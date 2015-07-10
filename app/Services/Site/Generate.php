<?php

namespace App\Services\Site;

use App\Jobs\GenerateSite;
use App\Models\Group;
use App\Models\Site;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Str;

class Generate
{

    use DispatchesJobs;

    /* @var Site */
    private $site;

    /* @var Group */
    private $group;

    public function __construct(Site $site, Group $group)
    {
        $this->site  = $site;
        $this->group = $group;
    }

    public function handle(array $request)
    {
        $group    = $this->group->find($request['group_id']);
        $sitePath = Str::camel($request['name']);

        if (settingEnabled('nginx') == 1) {
            $this->createNginxSite($request, $group, $sitePath);
        } elseif (settingEnabled('homestead') == 1) {
            $this->createHomesteadSite($request, $group, $sitePath);
        }
    }

    /**
     * Add an nginx site to the database and filesystem.
     *
     * @param array   $request
     * @param         $group
     * @param         $sitePath
     *
     * @return Site
     */
    private function createNginxSite(array $request, $group, $sitePath)
    {
        $site = [
            'name'          => $request['name'],
            'path'          => $group->starting_path . '/' . $sitePath . '/public',
            'port'          => $group->maxPort,
            'group_id'      => $group->id,
            'uuid'          => $this->site->generateUuid($group->maxPort . $request['name']),
            'homesteadFlag' => 0,
        ];

        $site = $this->site->create($site);

        $this->dispatch(new GenerateSite($site, $request));
    }

    /**
     * Add a homestead site to the database and filesystem.
     *
     * @param array $request
     * @param Group $group
     * @param       $sitePath
     *
     * @return Site
     */
    private function createHomesteadSite(array $request, Group $group, $sitePath)
    {
        $site = [
            'name'          => $request['name'],
            'path'          => $group->starting_path . '/' . $sitePath . '/public',
            'port'          => 8000,
            'group_id'      => $group->id,
            'uuid'          => $this->site->generateUuid($group->maxPort . $request['name']),
            'homesteadFlag' => 1,
        ];

        $site = $this->site->create($site);

        $this->dispatch(new GenerateSite($site, $request));
    }
}