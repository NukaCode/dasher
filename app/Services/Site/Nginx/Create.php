<?php

namespace App\Services\Site\Nginx;

use App\Resources\Nginx;
use App\Services\Site\BaseCreate;

class Create extends BaseCreate
{

    /**
     * Save the site to the database, create a config and add that config to nginx.
     *
     * @param $site
     * @param $groupId
     *
     * @return bool
     */
    public function handle($site, $groupId)
    {
        $uuid = $this->generateUuid($site);

        $site = $this->createSite($site, $groupId, $uuid);

        Nginx::createConfig($site);

        $this->envoy->run('nginx --cmd="reload"');

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