<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;
use NukaCode\Core\Controllers\BaseController as CoreBaseController;
use NukaCode\Menu\Link;

abstract class BaseController extends CoreBaseController
{

    use DispatchesJobs, ValidatesRequests;

    protected $resetBlade = false;

    protected function setJavascriptData($key, $value = null)
    {
        if (is_array($key)) {
            JavaScriptFacade::put($key);
        } else {
            JavaScriptFacade::put([$key => $value]);
        }
    }
}
