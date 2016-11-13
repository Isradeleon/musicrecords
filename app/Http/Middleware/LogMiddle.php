<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class LogMiddle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Auth::check() || $request->isMethod('POST')) {
            return $next($request);
        }
        return redirect('/');
    }
}
