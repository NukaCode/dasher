<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Services\Site\Generate;
use Illuminate\Http\Request;

class SiteController extends BaseController
{

    /**
     * Show the form to generate a new Laravel site.
     *
     * @param Group $group
     *
     * @return Response
     */
    public function generate(Group $group)
    {
        $groups           = $group->orderByNameAsc()->lists('name', 'id');
        $installerOptions = config('nukacode-installer.options');

        $this->setViewData(compact('groups', 'installerOptions'));
    }

    /**
     * Store a newly generated site.
     *
     * @param Request  $request
     * @param Generate $siteGenerateService
     *
     * @return Response
     */
    public function storeGenerated(Request $request, Generate $siteGenerateService)
    {
        list($success, $messages) = $siteGenerateService->handle($request);

        if ($success) {
            return redirect(route('home'))->with('message', 'Site generated!');
        }

        return redirect(route('site.generate'))->withInput()->withErrors($messages);
    }
}
