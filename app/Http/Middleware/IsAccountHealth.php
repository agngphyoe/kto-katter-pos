<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAccountHealth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && !auth()->user()->status) {

            auth()->logout();
            
            return redirect()->route('login')->withErrors(
                [
                    'account_frozen' => 'Your account is frozen. Please contact to admin.',
                ]
            );
        }

        return $next($request);
    }
}
