<?php

namespace Teckipro\Admin\Http\Middleware;

use Closure;

/**
 * Class SuperAdminCheck.
 */
class SuperAdminCheck
{
    /**
     * @param $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() && $request->user()->hasAllAccess() && $request->user()->id===1) {
            return $next($request);
        }

        return redirect()->route(env('FRONTENDROUTENAME').'.index')->withFlashDanger(__('You do not have access to do that.'));
    }
}
