<?php

namespace Teckipro\Admin\Models\Traits\Method;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Teckipro\Admin\Models\Package;
use Teckipro\Admin\Models\User;
use Teckipro\Admin\Models\Role;
use Teckipro\Admin\Models\Traits\Method\UserMethod;

/**
 * Trait UserMethod.
 */
trait PlanMethod
{

   use UserMethod;


 /**
  * Retrict action to be performed only by super admin
  */
   public function restrictOnlyToSuperAdmin(){
    if(!auth()->user()->isMasterAdmin()){
        return redirect()->route('admin.dashboard')->withFlashDanger(__('You are not permitted to perform this operation.'));
      }
   }


    /**
     * @param $permission,$user_id
     * Check if a user has a certain permission
     */
    public function userHavePermissionAccess($permission,$user_id){
      $user_permissions = DB::table('model_has_permissions')->where('model_id',$user_id)
      ->join('permissions', 'permissions.id', '=', 'model_has_permissions.permission_id')
        ->select('permissions.name')
        ->get();

      $status = false;
      foreach($user_permissions as $user_permission){
        if($user_permission->name==$permission){
            $status = true;
        }
      }
      return $status;
    }



     /**
     * Assign permission and roles to user
     * base on package id
     */
    public function assignPermissionAndRolesToUser($package_id,$user){
        //Get role ids from package
        $role_ids = $this->model::where('id','=',$package_id)->get()->pluck('role_ids')->first();
        $role_ids = explode(',',$role_ids);


        if(empty($role_ids)){
          return false;
        }
        foreach($role_ids as $role_id){

          $resp = $this->getRolePermissionsByRoleId($role_id,true);
          $rolename = $resp['name'];
          $permissions = $resp['permissions'];
          //add role
          $user->assignRole($rolename);
          //add all permissions
          $user->givePermissionTo($permissions);

        }
        return true;


      }

    /**
     * return the role name and it's permissions
     * using the role id
     * @param roled_id
     */
    public function getRolePermissionsByRoleId($role_id,$filterPermissionNameOut=false){

                    $role_name = DB::table('roles')->where('id',$role_id)->value('name');
                    //get the permissions of this role
                    $permissions = DB::table('role_has_permissions')->where('role_id',$role_id)
                    ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                    ->select('permissions.name')
                    ->get();

                    $filteredpermissionlist = array();

                    if($filterPermissionNameOut){
                        if(!empty($permissions)){
                            foreach($permissions as $permission){
                                $filteredpermissionlist[] = $permission->name;
                            }
                        }
                    }

                    return[
                        'name'=>$role_name,
                        'permissions'=> $filterPermissionNameOut?$filteredpermissionlist:$permissions
                    ];

    }

    /**
     * As the package is been updated,
     * Add/Remove roles and permissions to already assigned
     * users.
     */
    public function updateUsersRoleAndPermissionsByPackage(){
        $validated = $this->request->validated();
        $new_role_ids  = $validated['role_ids'];
        $package_id = $this->package_id;
        $removed_roles = array();
        $added_roles = array();

        $original_package_roles = Package::find($package_id)->value('role_ids');
        $original_package_roles = explode(',',$original_package_roles);

        /**
         * Filtering for added roles
         */
        foreach($new_role_ids as $new_role_id){
            if(!in_array($new_role_id, $original_package_roles)){
                $added_roles[] = $new_role_id;
            }
        }

        /**
         * Filtering for removed roles
         */
        foreach($original_package_roles as $original_package_role){

            if(!in_array($original_package_role,$new_role_ids)){
                $removed_roles[] = $original_package_role;
            }

         }


         $packageSubscribedUsers = DB::table('launch_subscriptions')->where('package_id',$package_id)->get();
         if(!empty($packageSubscribedUsers)){
            foreach($packageSubscribedUsers as $packageSubscribedUser){
                $user_id = $packageSubscribedUser->user_id;
                $user = User::find($user_id);

                //Process removed roles
                if(!empty($removed_roles)){
                foreach($removed_roles as $role_id){
                   $resp = $this->getRolePermissionsByRoleId($role_id,true);
                   $rolename = $resp['name'];
                   $permissions = $resp['permissions'];
                   //remove role
                   $user->removeRole($rolename);
                   //remove all permissions
                   $user->revokePermissionTo($permissions);

                }}

                //Process added subscribers
                if(!empty($added_roles)){
                    foreach($added_roles as $role_id){
                        $resp = $this->getRolePermissionsByRoleId($role_id,true);
                        $rolename = $resp['name'];
                        $permissions = $resp['permissions'];
                        //add role
                        $user->assignRole($rolename);
                        //add all permissions
                        $user->givePermissionTo($permissions);
                     }
                }


            }
         }

        return true;

    }


}
