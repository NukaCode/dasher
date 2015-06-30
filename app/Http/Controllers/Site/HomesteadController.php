<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\BaseController;
use App\Models\Group;
use App\Models\Site;
use App\Resources\Hosts;
use App\Services\Site\Homestead\Create;
use App\Services\Site\Homestead\Delete;
use App\Services\Site\Homestead\Edit;
use Illuminate\Http\Request;

class HomesteadController extends BaseController
{

    /**
     * Show the form for creating a new resource.
     *
     * @param Group $group
     * @param       $id
     *
     * @return Response
     */
    public function create(Group $group, $id)
    {
        app(Hosts::class)->updateHost('comics.app', 'comics22.app');
        $group = $group->find($id);
        $url   = route('directory.lookup');

        $this->setJavascriptData(compact('url', 'group'));
        $this->setViewData(compact('group'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Create  $createSiteService
     * @param         $id
     *
     * @return Response
     */
    public function store(Request $request, Create $createSiteService, $id)
    {
        $createSiteService->handle($request->all(), $id);

        return redirect(route('home'))->with('message', 'Site Added!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @param Site $site
     *
     * @return Response
     */
    public function edit($id, Site $site)
    {
        $site = $site->find($id);
        $url  = route('directory.lookup');

        $this->setJavascriptData(compact('url', 'site'));
        $this->setViewData(compact('site'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int    $id
     * @param Request $request
     * @param Edit    $editSiteService
     *
     * @return Response
     */
    public function update($id, Request $request, Edit $editSiteService)
    {
        list($success, $messages) = $editSiteService->handle($id, $request->all());

        if ($success) {
            return redirect(route('home'))->with('message', 'Site updated!');
        }

        return redirect(route('site.edit', [$id]))->withInput()->withErrors($messages);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int   $id
     * @param Delete $deleteSiteService
     *
     * @return Response
     */
    public function destroy($id, Delete $deleteSiteService)
    {
        $deleteSiteService->handle($id);

        return redirect(route('home'))->with('message', 'Site Removed!');
    }
}
