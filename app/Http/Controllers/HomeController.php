<?php

namespace App\Http\Controllers;

use App\Services\Envoy;

class HomeController extends BaseController
{

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index(Envoy $envoy)
    {
        pp($envoy->run('nuka-installer'));
    }
}
