<?php

namespace App\Services\Site\Nginx;

use App\Jobs\CreateSite;
use App\Services\Site\BaseCreate;
use Illuminate\Foundation\Bus\DispatchesJobs;

class Create extends BaseCreate
{

    use DispatchesJobs;

    /**
     * Save the site to the database, create a config and add that config to nginx.
     *
     * @param $request
     * @param $groupId
     *
     * @return bool
     */
    public function handle($request, $groupId)
    {
        $uuid = $this->site->generateUuid($request['port'] . $request['name']);

        $site = $this->createSite($request, $groupId, $uuid);

        $this->dispatch(new CreateSite($site, $request));

        return [true, null];
    }

    /**
     * Generate an array of attributes to create a site object.
     *
     * @param $site
     * @param $uuid
     * @param $group_id
     *
     * @return array
     */
    protected function setUpSite($site, $uuid, $group_id)
    {
        $path = str_replace('//', '/', $site['path']);
        $name = $site['name'];
        $port = $site['port'];

        return compact('path', 'name', 'port', 'uuid', 'group_id');
    }
}