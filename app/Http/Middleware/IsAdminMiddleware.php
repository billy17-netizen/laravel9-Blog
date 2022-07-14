<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role->name === 'admin') {
            return $next($request);
        }
        abort(403, 'You are not authorized to access this page.');
//        return $next($request);
    }
}
