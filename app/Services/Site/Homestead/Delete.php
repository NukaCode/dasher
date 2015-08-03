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

        app(Homestead::class)->deleteConfig($site);

        $site->delete();

        $this->envoy->run('vagrant --cmd="provision" --path="' . setting('homestead') . '"');
        app(Hosts::class)->removeHost($site->name);

        return [true, null];
    }
}