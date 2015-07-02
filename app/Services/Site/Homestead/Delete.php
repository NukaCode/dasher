<?php

namespace App\Services\Site\Homestead;

use App\Resources\Homestead;
use App\Resources\Hosts;
use App\Services\Site\BaseDelete;
use Illuminate\Support\Str;

class Delete extends BaseDelete
{

    public function handle($id)
    {
        $site = $this->site->find($id);

        $this->removeFromHomestead($site);

        $site->delete();

        $this->envoy->run('vagrant --cmd="provision" --dir="' . setting('homestead') . '"');
        app(Hosts::class)->removeHost($site->name);

        return [true, null];
    }

    private function removeFromHomestead($site)
    {
        // Convert yaml to array
        $config = $this->yaml->parse($this->filesystem->get(setting('userDir') . '/.homestead/Homestead.yaml'));

        // Look for the site in sites and in databases
        foreach ($config['sites'] as $key => $homesteadSite) {
            if ($homesteadSite['map'] == $site->name) {
                unset($config['sites'][$key]);
            }
        }

        foreach ($config['databases'] as $key => $homesteadDatabase) {
            if ($homesteadDatabase == Str::snake(str_replace('.app', '', $site->name))) {
                unset($config['databases'][$key]);
            }
        }

        // Rebuild the yaml
        app(Homestead::class)->saveHomesteadConfig($config);
    }
}