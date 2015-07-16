<?php

namespace App\Http\Controllers;

use App\Models\PortForward;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends BaseController
{

    /* @var Setting */
    private $setting;

    public function __construct(Setting $setting)
    {
        parent::__construct();

        $this->setting = $setting;
    }

    /**
     * Display a listing of the resource.
     *
     * @param PortForward $forward
     *
     * @return Response
     */
    public function index(PortForward $forward)
    {
        $settings = $this->setting->all();
        $forwards = $forward->orderBy('starting_port', 'asc')->get();

        $this->setViewData(compact('settings', 'forwards'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
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
        //
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
        $setting = $this->setting->find($id);

        $this->setViewData(compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $setting = $this->setting->find($id);
        $setting->fill($request->all());
        $setting->save();

        return redirect(route('setting.index'))->with('message', 'Setting has been updated.');
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
        //
    }
}
