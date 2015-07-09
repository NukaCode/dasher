<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateSite;
use App\Models\Group;
use App\Models\Site;

class HomeController extends BaseController
{

    /**
     * Show the application dashboard to the user.
     *
     * @param Group $group
     *
     * @return Response
     */
    public function index(Group $group)
    {
        $groups = $group->with('sites')->get();

        $this->setJavascriptData(compact('groups'));
    }
}
