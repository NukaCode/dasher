<?php

namespace App\Services\Site\Nginx;

use App\Resources\Nginx;

class Edit extends BaseEdit
{

    /**
     * Save the site to the database, create a config and add that config to nginx.
     *
     * @param $id
     * @param $request
     *
     * @return bool
     */
    public function handle($id, $request)
    {
        // Make sure the port is free
        if (! $this->verifyPort($id, $request)) {
            return [false, 'Port is already taken by another site!'];
        }

        $site = $this->updateSite($id, $request);

        Nginx::createConfig($site);

        $this->envoy->run('nginx --cmd="reload"');

        return [true, null];
    }
}