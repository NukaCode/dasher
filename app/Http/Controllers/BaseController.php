<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;
use NukaCode\Core\Controllers\BaseController as CoreBaseController;

abstract class BaseController extends CoreBaseController
{

    use DispatchesJobs, ValidatesRequests;

    protected $resetBlade = false;

    public function __construct()
    {
        parent::__construct();

        $this->setUpMenu();
    }

    protected function setUpMenu()
    {
        \Menu::add('leftMenu')
             ->quickLink('Home', 'home')
             ->quickLink('Groups', 'group.index')
             ->end();
    }

    protected function setJavascriptData($key, $value = null)
    {
        if (is_array($key)) {
            JavaScriptFacade::put($key);
        } else {
            JavaScriptFacade::put([$key => $value]);
        }
    }
}
