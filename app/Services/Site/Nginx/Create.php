<?php

namespace App\Services\Site\Nginx;

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

        $this->generateNginxConfig($site);

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

    /**
     * Generate the nginx config based on the saved template and the site data.
     *
     * @param $site
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function generateNginxConfig($site)
    {
        // Get the config template
        $template = $this->filesystem->get(base_path('resources/templates/nginx.conf.template'));

        // Replace the needed data
        $config = str_replace(['{{NAME}}', '{{PORT}}', '{{PATH}}'], [$site->name, $site->port, $site->path], $template);

        // Save the config to the filesystem.
        $filename = $this->nginxConfigDir . $site->uuid;

        $this->filesystem->put($filename, $config);
        exec('xattr -w com.apple.TextEncoding \'utf-8;134217984\' ' . $filename);
    }
}