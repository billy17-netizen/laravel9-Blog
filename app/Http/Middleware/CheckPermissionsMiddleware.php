<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermissionsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        //Admin has all permissions
        if (auth()->user()->role->name === 'admin') {
            return $next($request);
        }
        // get the route name
        $route_name = $request->route()->getName();
        // get permissions for this authenticated person
        $route_arr = auth()->user()->role->permissions->toArray();
        // compare the route name with the permissions
        foreach ($route_arr as $route) {
            // if this route name is one of these permissions
            if ($route['name'] === $route_name) {
                // allow user to access the route
                return $next($request);
            }
        }
        // else about 403 Unauthorized Access
        abort(403, 'Access Denied | Unauthorized ');
    }
}
