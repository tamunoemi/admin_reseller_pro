<?php

namespace Teckipro\Admin\Http\Controllers\User;

use Teckipro\Admin\Models\User;
use Teckipro\Admin\Services\UserService;

/**
 * Class DeletedUserController.
 */
class DeletedUserController
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * DeletedUserController constructor.
     *
     * @param  UserService  $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('teckiproadmin::auth.user.deleted');
    }

    /**
     * @param  User  $deletedUser
     * @return mixed
     *
     * @throws \App\Exceptions\GeneralException
     */
    public function update(User $deletedUser)
    {
        $this->userService->restore($deletedUser);

        return redirect()->route('admin.auth.user.index')->withFlashSuccess(__('The user was successfully restored.'));
    }

    /**
     * @param  User  $deletedUser
     * @return mixed
     *
     * @throws \App\Exceptions\GeneralException
     */
    public function destroy(User $deletedUser)
    {
        abort_unless(config('boilerplate.access.user.permanently_delete'), 404);

        $this->userService->destroy($deletedUser);

        return redirect()->route('admin.auth.user.deleted')->withFlashSuccess(__('The user was permanently deleted.'));
    }
}
