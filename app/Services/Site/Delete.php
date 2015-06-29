<?php

namespace App\Services\Site;

use App\Models\Site;
use App\Services\Envoy;
use Illuminate\Filesystem\Filesystem;

class Delete
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

    public function handle($id)
    {
        $site = $this->site->find($id);

        $this->filesystem->delete($this->nginxConfigDir . $site->uuid);

        $site->delete();

        $this->envoy->run('nginx --cmd="reload"');

        return true;
    }
}