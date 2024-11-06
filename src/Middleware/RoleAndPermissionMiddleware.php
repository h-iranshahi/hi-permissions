<?php

namespace Iransh\HiPermissions\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleAndPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role, $permission = null): Response
    {
        if($role)
        {
            if(!$request->user()->hasRole($role))
            {
                abort(404);
            }
        }

        if($permission)
        {
            if(!$request->user()->can($permission))
            {
                abort(404);
            }
        }

        return $next($request);
    }
}
