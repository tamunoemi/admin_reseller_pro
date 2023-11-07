<?php

namespace Teckipro\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Teckipro\Admin\Models\Modules;
use Teckipro\Admin\Http\Requests\CreateModuleRequest;
use Illuminate\Support\Facades\DB;

class ModuleController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('teckiproadmin::modules.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
 
        return view('teckiproadmin::modules.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateModuleRequest $request)
    {
        $data = $request->all();
        unset($data['_token']);
        unset($data['submit']);
        $data['limit_enabled'] = $limit_enabled = isset($data['limit_enabled']) && $data['limit_enabled']=='on'? '1':'0';
        $data['bulk_limit_enabled'] = $bulk_limit_enabled = isset($data['bulk_limit_enabled']) && $data['bulk_limit_enabled']=='on'? '1':'0';
   
        Modules::create($data);
  

        return redirect()->route('admin.module.index')->withFlashSuccess(__('The module was successfully created.'));
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Modules = new Modules();
        $data = $Modules::find($id);
        return view('teckiproadmin::modules.edit')->withData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateModuleRequest $request, $id)
    {
      
        $m = Modules::find($id);

        $data = $request->all();
        unset($data['_token']);
        unset($data['submit']);
        $data['limit_enabled'] = isset($data['limit_enabled']) && $data['limit_enabled']=='on'? '1':'0';
        $data['bulk_limit_enabled'] = isset($data['bulk_limit_enabled']) && $data['bulk_limit_enabled']=='on'? '1':'0';
        $m->update($data);

        return redirect()->route('admin.module.index')->withFlashSuccess(__('The module was successfully updated.'));
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $modules = Modules::find($id);
        $data['deleted'] = '1';
        $modules->update($data);

        return redirect()->back()->withFlashSuccess(__('The module was successfully deleted.'));
    }
}
