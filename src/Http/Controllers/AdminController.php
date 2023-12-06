<?php

namespace Teckipro\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Teckipro\Admin\Http\Requests\User\DeleteUserRequest;
use Teckipro\Admin\Http\Requests\User\EditUserRequest;
use Teckipro\Admin\Http\Requests\User\StoreUserRequest;
use Teckipro\Admin\Http\Requests\User\UpdateUserRequest;
use Teckipro\Admin\Models\User;
use Teckipro\Admin\Services\PermissionService;
use Teckipro\Admin\Services\RoleService;
use Teckipro\Admin\Services\UserService;

use Teckipro\Admin\Services\PackageService;
use Teckipro\Admin\Domains\Plans\Http\Controllers\PlanController;
use Teckipro\Admin\Http\Requests\UpdatePackageRequest;

use Teckipro\Admin\Models\LaunchSubscriptionModel as LaunchModel;
use Teckipro\Admin\Models\ModelHasRoles;
use Illuminate\Support\Facades\DB;
use Teckipro\Admin\Models\Permission;
use Teckipro\Admin\Models\ModelHasPermissions;
use Teckipro\Admin\Models\Package;
use Teckipro\Admin\Models\Role;

use Teckipro\Admin\Traits\PaddleTrait;
use Teckipro\Admin\Models\Traits\Method\PackageMethod;



class AdminController
{

    use PaddleTrait;
    use PackageMethod;


    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var RoleService
     */
    protected $roleService;

    /**
     * @var PermissionService
     */
    protected $permissionService;

      /**
     * @var PlanController
     */
    protected $PlanController;

    /**
     * @var PackageService
     */
    protected $packageService;

    /**
     * @var UserSubscriptionService
     */
    protected $userSubscriptionService;
    protected $launchModel;

    /**
     * UserController constructor.
     *
     * @param  UserService  $userService
     * @param  RoleService  $roleService
     * @param  PermissionService  $permissionService
     */
    public function __construct(
        UserService $userService,
        RoleService $roleService,
        PermissionService $permissionService,
        PlanController $PlanController,
        PackageService $packageService,
        LaunchModel $launchModel
        )
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
        $this->PlanController = $PlanController;
        $this->packageService = $packageService;
        $this->launchModel = $launchModel;
    }

     /**
     * @param  EditUserRequest  $request
     * @param  User  $user
     * @return mixed
     */
    public function edit(EditUserRequest $request, User $user)
    {

        return view('teckiproadmin::auth.user.edit')
            ->withUser($user)
            ->withRoles($this->roleService->get())
            ->withCategories($this->permissionService->getCategorizedPermissions())
            ->withGeneral($this->permissionService->getUncategorizedPermissions())
            ->withUsedPermissions($user->permissions->modelKeys())
            ->withPackageOptions($this->PlanController->packageSelectOptions)
            ->withLaunchPackages($this->packageService->getLaunchPackages())
            ->withSaasPackages($this->packageService->getSaasPackages())
            ->withLaunchPackageTypes($this->packageService->launchSubscriptionModel::type)
            ;
    }

    /**
     * @param  UpdateUserRequest  $request
     * @param  User  $user
     * @return mixed
     *
     * @throws \Throwable
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        $data['phone'] = $request['phone'];
        $data['active'] = $request['active'];
        $data['address'] = $request['address'];

        $this->userService->update($user,$data);

        return redirect()->route('admin.auth.user.show', $user)->withFlashSuccess(__('The user was successfully updated.'));
    }


    public function updatesubscription(UpdatePackageRequest $request, User $user){



        $data = $request->validated();

        //Assign permissions to user
        $this->packageService->assignPermissionAndRolesToUser($data['package_id'],$user);

        $type = $data['type'];
        if($type==PlanController::TYPE_LAUNCH){
         //Subscribe user to launch plan
         $this->packageService->launchSubscription($data,$user);

         //subscribe user as paddle customer
         $this->launchUserSubscription($data,$user);


         //send out email notification
        }elseif($type==PlanController::TYPE_SAAS){
         $this->packageService->sassSubscription($data,$user);

        }



       return redirect()->back()->withFlashSuccess(__('User subscribed to package successfully.'));


    }

    /**
     * @userLaunchPackageEdit
     */
    public function userLaunchPackageEdit():void
    {

    }

    /**
     * @updateUserLaunchPackage
     */
    public function updateUserLaunchPackage():void
    {

    }

    /**
     * @destroyUserLaunchPackage
     */
    public function destroyUserLaunchPackage($id)
    {
     //Only super admin can delete a package
     $this->restrictOnlyToSuperAdmin();

     $launchdetails = $this->launchModel::find($id);
     $user_id = $launchdetails->user_id;
     $user = User::find($user_id);
     $role_ids = Package::where('id','=',$launchdetails->package_id)->get()->value('role_ids');
     $role_ids = @explode(',',$role_ids);


     if(!empty($role_ids)){
     foreach($role_ids as $role_id){

       $resp = $this->getRolePermissionsByRoleId($role_id,true);
       $rolename = $resp['name'];
       $permissions = $resp['permissions'];
       //remove role
       $user->removeRole($rolename);
       //remove all permissions
       $user->revokePermissionTo($permissions);

     }
   }

     $launchdetails->delete();
     return redirect()->route('admin.auth.user.edit',$user)->withFlashSuccess(__('The role revoked and subscription deleted successfully deleted.'));

    }

     /**
     * @destroyUserLaunchPackage
     */
    public function viewUserLaunchPackage():void
    {

    }


}
