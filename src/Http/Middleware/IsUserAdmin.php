<?php
namespace Teckipro\Admin\Http\Middleware;
use Teckipro\Admin\Models\User;
use Closure;
use Auth;



class IsUserAdmin
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {

        }
        return $next($request);
    }
}
