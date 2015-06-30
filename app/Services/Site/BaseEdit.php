<?php

namespace App\Services\Site;

use App\Models\Site;
use App\Services\Envoy;
use Illuminate\Filesystem\Filesystem;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Yaml\Yaml;

abstract class BaseEdit
{

    /* @var Site */
    protected $site;

    /* @var Envoy */
    protected $envoy;

    /* @var Filesystem */
    protected $filesystem;

    /* @var string */
    protected $nginxConfigDir;

    /* @var Yaml */
    protected $yaml;

    public function __construct(Site $site, Envoy $envoy, Filesystem $filesystem, Yaml $yaml)
    {
        $this->site           = $site;
        $this->envoy          = $envoy;
        $this->filesystem     = $filesystem;
        $this->nginxConfigDir = '/Users/travis/Library/Application Support/com.webcontrol.WebControl/nginx/sites/';
        $this->yaml           = $yaml;
    }

    /**
     * Updates the site data in the database.
     *
     * @param $id
     * @param $request
     *
     * @return mixed
     */
    protected function updateSite($id, $request)
    {
        $site = $this->site->find($id);
        $site->fill($request);
        $site->save();

        return $site;
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
        $this->saveConfig($filename, $config);
    }

    /**
     * Save the config to the filesystem and add the extended attributes.
     *
     * @param $filename
     * @param $config
     */
    protected function saveConfig($filename, $config)
    {
        $this->filesystem->put($filename, $config);
        exec('xattr -w com.apple.TextEncoding \'utf-8;134217984\' ' . $filename);
    }

    /**
     * Make sure the new port is not already being used.
     *
     * @param $id
     * @param $site
     *
     * @return bool
     */
    protected function verifyPort($id, $site)
    {
        return $this->site->where('id', '!=', $id)->where('port', $site['port'])->count() == 0;
    }
}