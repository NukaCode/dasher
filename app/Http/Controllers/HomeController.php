<?php

namespace App\Http\Controllers;

use App\Models\Group;

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
