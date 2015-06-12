<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use NukaCode\Core\Controllers\BaseController as CoreBaseController;

abstract class BaseController extends CoreBaseController
{

    use DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        parent::__construct();

        $this->setUpMenu();
    }

    protected function setUpMenu()
    {
        \Menu::add('leftMenu')
             ->quickLink('Home', 'home')
             ->quickLink('Memberlist', 'memberlist')
             ->end();

        if (\Auth::guest()) {
            \Menu::add('rightMenu')
                 ->quickLink('Login', 'login')
                 ->quickLink('Register', 'register')
                 ->end();
        } else {
            \Auth::user()->updateLastActive();
            \Menu::add('rightMenu')
                 ->addDropDown('Admin')
                 ->quickLink('Dashboard', 'admin.index')
                 ->end()
                 ->addDropDown(\Auth::user()->username)
                 ->addLink('Edit your profile')
                 ->setUrl('user/profile/')
                 ->end()
                 ->addLink('Public Profile')
                 ->setUrl('user/view/' . \Auth::user()->id)
                 ->end()
                 ->quickLink('Logout', 'logout')
                 ->end()
                 ->end();
        }
    }
}
