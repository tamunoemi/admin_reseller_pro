<?php

namespace Teckipro\Admin\Http\Controllers\User;

use Teckipro\Admin\Http\Requests\User\ClearUserSessionRequest;
use Teckipro\Admin\Models\User;

/**
 * Class UserSessionController.
 */
class UserSessionController
{
    /**
     * @param  ClearUserSessionRequest  $request
     * @param  User  $user
     * @return mixed
     */
    public function update(ClearUserSessionRequest $request, User $user)
    {
        $user->update(['to_be_logged_out' => true]);

        return redirect()->back()->withFlashSuccess(__('The user\'s session was successfully cleared.'));
    }
}
