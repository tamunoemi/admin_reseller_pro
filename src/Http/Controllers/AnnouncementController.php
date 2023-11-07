<?php

namespace Teckipro\Admin\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Teckipro\Admin\Announcement\Models\Announcement;

/**
 * Class  Tutorials
 */
class AnnouncementController
{

    public const TYPE_GLOBAL = "";
    public const TYPE_FRONTEND = "frontend";
    public const TYPE_BACKEND = "backend";

    public const area = array(
        ''=>self::TYPE_GLOBAL,
        'frontend'=>self::TYPE_FRONTEND,
        'backend'=>self::TYPE_BACKEND
    );

    public const type = array(
        'success'=>'success',
        'danger'=>'danger',
        'info'=>'info'
    );

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('teckiproadmin::announcement.index');
    }

    public function create(){
      
        return view('teckiproadmin::announcement.create')->withTypes(self::type)->withArea(self::area);
    }

    public function store(Request $request):RedirectResponse
    {
        $validated = $request->validate([
            'area' => [Rule::in([self::TYPE_FRONTEND, self::TYPE_BACKEND, self::TYPE_GLOBAL])],
            'type'=>'required',
            'message'=>'required',
            'starts_at'=>'required|date',
            'ends_at'=>'required|date',
            'enabled'=>'nullable'
        ]);

        $data = $validated;
        $data['enabled'] = $validated['enabled']=='on' ? '1':'0';
        Announcement::create($data);
        return redirect()->route('admin.announcement.index')->withFlashSuccess(__('The announcement was successfully added.'));
       
    }


  

    public function destroy($id){
     
        $t = Announcement::find($id);
        $t->delete();

        return redirect()->route('admin.announcement.index')->withFlashSuccess(__('The announcement was successfully deleted.'));

    }


}

