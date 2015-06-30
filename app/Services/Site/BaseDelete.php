<?php

namespace App\Services\Site;

use App\Models\Site;
use App\Services\Envoy;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

abstract class BaseDelete
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
}
