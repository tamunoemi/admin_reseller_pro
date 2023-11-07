<?php

namespace Teckipro\Admin\Http\Controllers\User;

use Teckipro\Admin\Http\Requests\User\EditUserPasswordRequest;
use Teckipro\Admin\Http\Requests\User\UpdateUserPasswordRequest;
use Teckipro\Admin\Models\User;
use Teckipro\Admin\Services\UserService;

/**
 * Class UserPasswordController.
 */
class UserPasswordController
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * UserPasswordController constructor.
     *
     * @param  UserService  $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param  EditUserPasswordRequest  $request
     * @param  User  $user
     * @return mixed
     */
    public function edit(EditUserPasswordRequest $request, User $user)
    {
        return view('teckiproadmin::auth.user.change-password')
            ->withUser($user);
    }

    /**
     * @param  UpdateUserPasswordRequest  $request
     * @param  User  $user
     * @return mixed
     *
     * @throws \Throwable
     */
    public function update(UpdateUserPasswordRequest $request, User $user)
    {
        $this->userService->updatePassword($user, $request->validated());

        return redirect()->route('admin.auth.user.index')->withFlashSuccess(__('The user\'s password was successfully updated.'));
    }
}
