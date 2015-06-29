<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Services\Group\Create;
use App\Services\Group\Edit;
use Illuminate\Http\Request;

class GroupController extends BaseController
{

    /* @var Group */
    private $group;

    public function __construct(Group $group)
    {
        parent::__construct();

        $this->group = $group;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $groups = $this->group->orderByNameAsc()->get();

        $this->setViewData(compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $url = route('directory.lookup');

        $this->setJavascriptData(compact('url'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Create  $createGroupService
     *
     * @return Response
     */
    public function store(Request $request, Create $createGroupService)
    {
        list($success, $messages) = $createGroupService->handle($request->all());

        if ($success) {
            return redirect(route('group.index'))->with('message', 'Group added!');
        }

        return redirect(route('group.create'))->withInput()->withErrors($messages);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $group = $this->group->with('sites')->find($id);

        $this->setJavascriptData(compact('group'));
        $this->setViewData(compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $group = $this->group->find($id);
        $url   = route('directory.lookup');

        $this->setJavascriptData(compact('group', 'url'));
        $this->setViewData(compact('group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int    $id
     * @param Request $request
     * @param Edit    $editGroupService
     *
     * @return Response
     */
    public function update($id, Request $request, Edit $editGroupService)
    {
        list($success, $messages) = $editGroupService->handle($id, $request->all());

        if ($success) {
            return redirect(route('group.index'))->with('message', 'Group updated!');
        }

        return redirect(route('group.edit', [$id]))->withInput()->withErrors($messages);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $this->group->delete($id);

        return redirect(route('group.index'))->with('message', 'Group deleted!');
    }
}
