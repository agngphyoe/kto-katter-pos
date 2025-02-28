<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $roles_and_permissions)
    {
        $user = $request->user();
        $roles_and_permissions_array = explode('|', $roles_and_permissions);

        foreach ($roles_and_permissions_array as $item) {

            if ($user->hasRole($item) || $user->hasPermissions($item)) {

                return $next($request);
            }
        }

        return response()->view('403');
        // return $next($request);
    }
}
