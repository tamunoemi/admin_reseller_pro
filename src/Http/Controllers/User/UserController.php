<?php

namespace Teckipro\Admin\Http\Controllers\User;

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


/**
 * Class UserController.
 */
class UserController
{

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
        PackageService $packageService
        )
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
        $this->PlanController = $PlanController;
        $this->packageService = $packageService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('teckiproadmin::auth.user.index');
    }

    /**
     * @return mixed
     */
    public function create()
    {
        return view('teckiproadmin::auth.user.create')
            ->withRoles($this->roleService->get())
            ->withCategories($this->permissionService->getCategorizedPermissions())
            ->withGeneral($this->permissionService->getUncategorizedPermissions());
    }

    /**
     * @param  StoreUserRequest  $request
     * @return mixed
     *
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function store(StoreUserRequest $request)
    {
        $user = $this->userService->store($request->validated());

        return redirect()->route('admin.auth.user.show', $user)->withFlashSuccess(__('The user was successfully created.'));
    }

    /**
     * @param  User  $user
     * @return mixed
     */
    public function show(User $user)
    {
        return view('teckiproadmin::auth.user.show')
            ->withUser($user);
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

    /**
     * @param  DeleteUserRequest  $request
     * @param  User  $user
     * @return mixed
     *
     * @throws \App\Exceptions\GeneralException
     */
    public function destroy(DeleteUserRequest $request, User $user)
    {
        $this->userService->delete($user);

        return redirect()->route('admin.auth.user.deleted')->withFlashSuccess(__('The user was successfully deleted.'));
    }


}
