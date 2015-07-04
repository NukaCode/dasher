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

    public function __construct(Site $site, Envoy $envoy)
    {
        $this->site  = $site;
        $this->envoy = $envoy;
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