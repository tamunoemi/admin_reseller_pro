<?php

namespace Teckipro\Admin\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Teckipro\Admin\Models\Tutorials;


/**
 * Class  Tutorials
 */
class TutorialController
{

    public const TYPE_HTMLVIDEO = "htmlvideourl";
    public const TYPE_YOUTUBE = "youtubeid";
    public const TYPE_VIMEO = "videoid";

    public const type = array(
        'htmlvideo'=>self::TYPE_HTMLVIDEO,
        'youtube'=>self::TYPE_YOUTUBE,
        'vimeo'=>self::TYPE_VIMEO
    );

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('teckiproadmin::tutorials.index');
    }

    public function create(){
      
        return view('teckiproadmin::tutorials.create')->withTutorialOptions(self::type);
    }

    public function store(Request $request):RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'bail|required|unique:tutorials|max:255',
            'type' => ['required',Rule::in([self::TYPE_HTMLVIDEO, self::TYPE_YOUTUBE, self::TYPE_VIMEO])],
            'video_url'=>'required',
            'visible'=>'nullable'
        ]);
        $data = $validated;
        $data['visible'] = $validated['visible']=='on' ? '1':'0';
        Tutorials::create($data);
        return redirect()->route('admin.tutorial.index')->withFlashSuccess(__('The tutorial was successfully added.'));
       
    }


    public function edit(Tutorials $tutorial){

        return view('teckiproadmin::tutorials.edit')->withTutorialData($tutorial)->withTutorialOptions(self::type);
    }

    public function update(Request $request,$id){
      
        $validated = $request->validate([
            'title' => 'bail|required|max:255',
            'type' => ['required',Rule::in([self::TYPE_HTMLVIDEO, self::TYPE_YOUTUBE, self::TYPE_VIMEO])],
            'video_url'=>'required',
            'visible'=>'nullable'
        ]);
        $data = $validated;
        $data['visible'] = isset($validated['visible']) && $validated['visible']=='on' ? '1':'0';
        $tutorial = Tutorials::find($id);
        $tutorial->update($data);
        return redirect()->route('admin.tutorial.index')->withFlashSuccess(__('The tutorial was updated successfully.'));
 
    }

    public function destroy($id){
     
        $t = Tutorials::find($id);
        $t->delete();

        return redirect()->route('admin.tutorial.index')->withFlashSuccess(__('The tutorial was successfully deleted.'));

    }


}

