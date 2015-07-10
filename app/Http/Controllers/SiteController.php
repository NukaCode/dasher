<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateSite;
use App\Models\Group;
use App\Models\Site;
use App\Services\Site\Generate;
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
    public function generate(Group $group)
    {
        $groups           = $group->orderByNameAsc()->lists('name', 'id');
        $installerOptions = config('nukacode-installer.options');

        $this->setViewData(compact('groups', 'installerOptions'));
    }

    /**
     * Store a newly generated site.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function storeGenerated(Request $request, Generate $generateSiteService)
    {
        $generateSiteService->handle($request->all());

        return redirect(route('home'))->with('message', 'Site is being generated!');
    }
}
