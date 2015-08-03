<?php

namespace App\Services\Site\Generate;

use App\Events\SiteWasCloned;
use App\Services\Site\BaseGenerate;
use Illuminate\Support\Str;

class Clones extends BaseGenerate
{

    public function handle(array $request)
    {
        $group    = $this->group->find($request['group_id']);
        $sitePath = Str::camel($request['name']);

        if (settingEnabled('nginx') == 1) {
            $site = $this->createNginxSite($request, $group, $sitePath);
        } elseif (settingEnabled('homestead') == 1) {
            $site = $this->createHomesteadSite($request, $group, $sitePath);
        }

        event(new SiteWasCloned($site, $request));
    }

}
