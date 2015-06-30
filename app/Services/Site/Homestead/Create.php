<?php

namespace App\Services\Site\Homestead;

use App\Resources\Homestead;
use App\Resources\Hosts;
use App\Services\Site\BaseCreate;
use Illuminate\Support\Str;

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
        $site['port'] = 8000;
        $name         = $site['name'];

        $uuid = $this->generateUuid($site);

        $site = $this->createSite($site, $groupId, $uuid);

        $this->generateHomesteadConfig($site, $name);
        $this->addEnvConfig($name, $site);

        $this->envoy->run('vagrant --cmd="provision" --dir="' . setting('homesteadLocation') . '"');
        app(Hosts::class)->addHost($site->name);

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
        $path          = str_replace('//', '/', $site['path']);
        $name          = Str::snake($site['name']);
        $port          = $site['port'];
        $homesteadFlag = 1;

        if (strpos($name, '.app') === false) {
            $name .= '.app';
        }

        return compact('path', 'name', 'port', 'uuid', 'group_id', 'homesteadFlag');
    }

    /**
     * Updates the homestead.yaml file to include the new site.
     *
     * @param $site
     * @param $name
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function generateHomesteadConfig($site, $name)
    {
        $config = $this->yaml->parse($this->filesystem->get(setting('userDir') . '/.homestead/Homestead.yaml'));

        // Add the site to the config
        $config['sites'][] = [
            'map' => $site->name,
            'to'  => vagrantDirectory($site->path),
        ];

        // Add the database to the config
        $config['databases'][] = Str::snake($name);

        app(Homestead::class)->saveHomesteadConfig($config);
    }
}