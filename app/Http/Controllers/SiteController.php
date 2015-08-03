<?php

namespace App\Http\Controllers;

use App\Models\Clones;
use App\Models\Group;
use App\Models\Site;
use App\Services\Site\Generate\Clones as CloneService;
use App\Services\Site\Generate\Install;
use Illuminate\Http\Request;

class SiteController extends BaseController
{

    public function editor(Site $site, $editor, $id)
    {
        // Make sure we know what to do
        $editorLocation = setting($editor);

        if ($editorLocation == null) {
            return redirect(route('home'))->withErrors('Please set the ' . ucfirst($editor) . ' location in <a href="' . route('setting.index') . '">settings</a>.');
        }

        $site    = $site->find($id);
        $command = str_replace(' ', '\ ', $editorLocation) . ' ' . $site->rootPath;

        exec($command . ' ' . $site->rootPath);

        return redirect(route('home'));
    }

    public function getJson(Site $site, $id)
    {
        return $site->find($id);
    }

    /**
     * Show the form to generate a new Laravel site.
     *
     * @param Group $group
     *
     * @return Response
     */
    public function install(Group $group)
    {
        $groups           = $group->orderByNameAsc()->lists('name', 'id');
        $installerOptions = config('nukacode-installer.options');

        $this->setViewData(compact('groups', 'installerOptions'));
    }

    /**
     * Store a newly generated site.
     *
     * @param Request $request
     * @param Install $installSiteService
     *
     * @return Response
     */
    public function storeInstall(Request $request, Install $installSiteService)
    {
        $installSiteService->handle($request->all());

        return redirect(route('home'))->with('message', 'Site is being generated!');
    }

    /**
     * Show the form to generate a new Laravel site.
     *
     * @param Group $group
     *
     * @return Response
     */
    public function clones(Group $group, Clones $clone)
    {
        $groups = $group->orderByNameAsc()->lists('name', 'id');
        $clones = $clone->orderByNameAsc()->lists('name', 'id');

        $this->setViewData(compact('groups', 'clones'));
    }

    /**
     * Store a newly generated site.
     *
     * @param Request      $request
     * @param CloneService $cloneSiteService
     *
     * @return Response
     */
    public function storeClone(Request $request, CloneService $cloneSiteService)
    {
        $cloneSiteService->handle($request->all());

        return redirect(route('home'))->with('message', 'Site is being generated!');
    }
}
