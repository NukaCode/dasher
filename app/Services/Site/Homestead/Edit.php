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

        $this->updateHomesteadConfig($originalSite, $newSite);

        $this->envoy->run('vagrant --cmd="provision" --dir="' . setting('homestead') . '"');
        app(Hosts::class)->updateHost($originalSite->name, $newSite->name);

        return [true, null];
    }

    /**
     * Updates the homestead.yaml file to include the new site.
     *
     * @param $originalSite
     * @param $newSite
     */
    protected function updateHomesteadConfig($originalSite, $newSite)
    {
        $config = $this->yaml->parse($this->filesystem->get(setting('userDir') . '/.homestead/Homestead.yaml'));

        // Check the sites and databases to see if we need to change anything.
        foreach ($config['sites'] as $key => $homesteadSite) {
            if ($homesteadSite['map'] == $originalSite->name) {
                $config['sites'][$key] = [
                    'map' => $newSite->name,
                    'to'  => vagrantDirectory($newSite->path)
                ];
            }
        }

        app(Homestead::class)->saveHomesteadConfig($config);
    }
}