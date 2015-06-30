<?php

namespace App\Services\Site;

use App\Models\Site;
use App\Services\Envoy;
use Illuminate\Filesystem\Filesystem;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Yaml\Yaml;

abstract class BaseCreate
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
     * Handles adding the site to the database.
     *
     * @param $site
     * @param $groupId
     * @param $uuid
     *
     * @return array|static
     * @throws \Exception
     */
    protected function createSite($site, $groupId, $uuid)
    {
        if (! method_exists($this, 'setUpSite')) {
            throw new \Exception('You need a setUpSite method to create a new site.');
        }

        $site = $this->setUpSite($site, $uuid, $groupId);
        $site = $this->site->create($site);

        return $site;
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

    protected function addEnvConfig($database, $site)
    {
        // Get the config template
        $template = $this->filesystem->get(base_path('resources/templates/.env.template'));

        // Replace the needed data
        $config = str_replace(['{{DATABASE}}'], [$database], $template);

        // Save the config to the filesystem.
        $filename = str_replace('public', '', $site->path) . '.env';

        $this->filesystem->put($filename, $config);
    }
}