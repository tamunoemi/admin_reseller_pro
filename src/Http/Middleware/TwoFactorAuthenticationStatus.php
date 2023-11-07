<?php

namespace Teckipro\Admin\Http\Middleware;

use Closure;
use Auth;
use Cache;

/**
 * Class TwoFactorAuthenticationStatus.
 */
class TwoFactorAuthenticationStatus
{
    /**
     * @param $request
     * @param  Closure  $next
     * @param  string  $status
     * @return mixed
     */
    public function handle($request, Closure $next, $status = 'enabled')
    {
        if (! in_array($status, ['enabled', 'disabled'])) {
            abort(404);
        }

        // If the backend does not require 2FA then continue
        if ($status === 'enabled' && $request->is('admin*') && ! config('boilerplate.access.user.admin_requires_2fa')) {
            return $next($request);
        }

        // Page requires 2fa, but user is not enabled or page does not require 2fa, but it is enabled
        if (
            ($status === 'enabled' && ! $request->user()->hasTwoFactorEnabled()) ||
            ($status === 'disabled' && $request->user()->hasTwoFactorEnabled())
        ) {
            return redirect()->route(env('FRONTENDROUTENAME').'.auth.account.2fa.create')->withFlashDanger(__('Two-factor Authentication must be :status to view this page.', ['status' => $status]));
        }

        return $next($request);
    }
}
