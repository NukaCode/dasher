<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\BaseController;
use App\Models\PortForward;
use Illuminate\Http\Request;

class PortController extends BaseController
{

    /* @var PortForward */
    private $forward;

    public function __construct(PortForward $forward)
    {
        parent::__construct();

        $this->forward = $forward;
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
        $port = $this->forward->create($request->all());

        if (! $port) {
            return redirect(route('port.create'))->withInput()->withErrors(['Failed to create port forward.']);
        }

        return redirect(route('setting.index'))->with('message', 'Forwarded port created!');
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
        $forward = $this->forward->find($id);

        $this->setViewData(compact('forward'));
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
        $port = $this->forward->find($id);
        $port->fill($request->all());
        $port->save();

        if (! $port) {
            return redirect(route('group.edit', [$id]))->withInput()->withErrors('Failed to update forwarded port.');
        }

        return redirect(route('setting.index'))->with('message', 'Port forward updated!');
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
        $this->forward->find($id)->delete();

        return redirect(route('setting.index'))->with('message', 'Forwarded port deleted!');
    }
}
