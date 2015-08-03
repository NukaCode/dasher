<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\BaseController;
use App\Models\Clones;
use Illuminate\Http\Request;

class CloneController extends BaseController
{

    /* @var Clones */
    private $clones;

    public function __construct(Clones $clones)
    {
        parent::__construct();

        $this->clones = $clones;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $clone = $this->clones->create($request->all());

        if (! $clone) {
            return redirect(route('clone.create'))->withInput()->withErrors(['Failed to create clone url.']);
        }

        return redirect(route('setting.index'))->with('message', 'Clone repo created!');
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
        $clones = $this->clones->find($id);

        $this->setViewData(compact('clones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int    $id
     * @param Request $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $clone = $this->clones->find($id);
        $clone->fill($request->all());
        $clone->save();

        if (! $clone) {
            return redirect(route('group.edit', [$id]))->withInput()->withErrors('Failed to update cloned repo.');
        }

        return redirect(route('setting.index'))->with('message', 'Clone repo updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int   $id
     *
     * @return Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $this->clones->find($id)->delete();

        return redirect(route('setting.index'))->with('message', 'Clone repo deleted!');
    }
}
