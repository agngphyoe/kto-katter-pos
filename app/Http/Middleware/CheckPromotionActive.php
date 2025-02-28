<?php

namespace App\Http\Middleware;

use App\Constants\PromotionType;
use App\Models\Promotion;
use Closure;
use Illuminate\Http\Request;

class CheckPromotionActive
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
        $promotion = Promotion::wherePromotionStatus(PromotionType::ACTIVE)->first();

        if (!$promotion) {

            return $next($request);
        } else {

            return redirect()->route('promotion')->with('error', 'Fail! Promotion is already active until ' . dateFormat($promotion->end_date) . '.');
        }
    }
}
