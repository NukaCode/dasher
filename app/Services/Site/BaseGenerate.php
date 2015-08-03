<?php

namespace App\Services\Site;

use App\Models\Group;
use App\Models\Site;

class BaseGenerate
{

    /* @var Site */
    protected $site;

    /* @var Group */
    protected $group;

    public function __construct(Site $site, Group $group)
    {
        $this->site  = $site;
        $this->group = $group;
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
    protected function createNginxSite(array $request, $group, $sitePath)
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

        return $site;
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
    protected function createHomesteadSite(array $request, Group $group, $sitePath)
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

        return $site;
    }
}