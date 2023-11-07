<?php

namespace Teckipro\Admin\Http\Controllers\Permissions;


use Teckipro\Admin\Models\Role;
use Teckipro\Admin\Services\PermissionService;
use Teckipro\Admin\Services\RoleService;
use Teckipro\Admin\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Class RoleController.
 */
class PermissionController
{
  
    public const TYPE_ADMIN = "admin";
    public const TYPE_USER = "user";
 

    public const type = array(
        'admin'=>self::TYPE_ADMIN,
        'user'=>self::TYPE_USER
    );

    public function index(){
        return view('teckiproadmin::permission.index');
    }

    public function create(){
      
        return view('teckiproadmin::permission.create')->withTypes(self::type);
    }

    public function store(Request $request):RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'bail|required|unique:permissions|max:255',
            'type' => ['required',Rule::in([self::TYPE_ADMIN,self::TYPE_USER])],
            'guard_name'=>'required',
            'description'=>'required',
            'parent_id'=>'nullable'

        ]);
        Permission::create([
            'type' => $validated['type'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'guard_name' => $validated['guard_name'],
            'parent_id' => $validated['parent_id'],
        ]);
        return redirect()->route('admin.permission.index')->withFlashSuccess(__('The permission was successfully added.'));
       
    }


    public function destroy($id){
        $t = Permission::find($id);
        $t->delete();

        return redirect()->route('admin.permission.index')->withFlashSuccess(__('The permission was successfully deleted.'));
       
    }


}
