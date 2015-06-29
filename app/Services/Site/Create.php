<?php

namespace App\Services\Site;

use App\Models\Site;
use App\Services\Envoy;
use Illuminate\Filesystem\Filesystem;
use Ramsey\Uuid\Uuid;

class Create
{

    /* @var Site */
    private $site;

    /* @var Envoy */
    private $envoy;

    /* @var Filesystem */
    private $filesystem;

    /* @var string */
    private $nginxConfigDir;

    public function __construct(Site $site, Envoy $envoy, Filesystem $filesystem)
    {
        $this->site           = $site;
        $this->envoy          = $envoy;
        $this->filesystem     = $filesystem;
        $this->nginxConfigDir = '/Users/travis/Library/Application Support/com.webcontrol.WebControl/nginx/sites/';
    }

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
        $this->checkIfExists($site['path']);

        $uuid = $this->generateUuid($site);

        $site = $this->createSite($site, $groupId, $uuid);

        $this->generateNginxConfig($site);

        $this->envoy->run('nginx --cmd="reload"');

        return true;
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
    private function setUpSite($site, $uuid, $group_id)
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
    private function generateNginxConfig($site)
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
     * Generate a uuid for the site based on it's port.
     *
     * @param $site
     *
     * @return string
     */
    protected function generateUuid($site)
    {
        $uuid3 = Uuid::uuid3(Uuid::NAMESPACE_DNS, $site['port']);
        $uuid  = $uuid3->toString();

        return $uuid;
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
     * See if the path exists.  Create a new laravel install if not.
     *
     * @param $path
     */
    private function checkIfExists($path)
    {
        if (! $this->filesystem->exists($path)) {
            $parts = explode('/', $path);
            $name  = end($parts);

            array_pop($parts);
            $path = implode('/', $parts);

            // Make sure the root directory exists.
            if (! $this->filesystem->exists($path)) {
                $this->filesystem->makeDirectory($path, 0755, true);
            }

            // Have envoy create the laravel site.
            $this->envoy->run('make-site --path="' . $path . '" --name="' . $name . '"');
        }
    }

    /**
     * @param $site
     * @param $groupId
     * @param $uuid
     *
     * @return array|static
     */
    protected function createSite($site, $groupId, $uuid)
    {
        $site = $this->setUpSite($site, $uuid, $groupId);
        $site = $this->site->create($site);

        return $site;
    }
}