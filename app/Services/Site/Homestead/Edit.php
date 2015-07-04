<?php

namespace App\Services\Site\Homestead;

use App\Resources\Homestead;
use App\Resources\Hosts;
use App\Services\Site\BaseEdit;
use Illuminate\Support\Str;

class Edit extends BaseEdit
{

    /**
     * Save the site to the database, create a config and add that config to homestead.
     *
     * @param $id
     * @param $request
     *
     * @return bool
     */
    public function handle($id, $request)
    {
        $originalSite = $this->site->find($id);
        $newSite      = $this->updateSite($id, $request);

        app(Homestead::class)->updateConfig($originalSite, $newSite);

        $this->envoy->run('vagrant --cmd="provision" --dir="' . setting('homestead') . '"');
        app(Hosts::class)->updateHost($originalSite->name, $newSite->name);

        return [true, null];
    }
}