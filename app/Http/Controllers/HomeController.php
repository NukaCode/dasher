<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Site;
use App\Services\Envoy;

class HomeController extends BaseController
{

    /**
     * Show the application dashboard to the user.
     *
     * @param Group $group
     *
     * @return Response
     */
    public function index(Group $group, Envoy $envoy)
    {
        $groups = $group->with('sites')->get();
        $siteJsonLink = route('site.json');

        $this->setJavascriptData(compact('groups', 'siteJsonLink'));
    }
}
