<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class IsAdminOrHR
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
        if (Auth::user() &&  Auth::user()->userType == 3 || Auth::user()->userType == 1) {
            return $next($request);
        }

        return redirect(route('dashboard'))->with('error_status','You do not have admin access');
    }
}
