<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PreventConsequentFormSubmit
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
        $route_path = explode('/', $request->path());

        $second_path = $route_path[0];

        $token = md5(json_encode($request->all()) . session()->getId());

        if (Session::get('form_token') === $token) {
            
            return redirect($second_path)->with('warning', 'Successfully, prevent subsequent form submissions to avoid duplicate entries');
        }

        Session::put('form_token', $token);

        return $next($request);
    }
}
