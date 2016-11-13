<?php

namespace App\Http\Middleware;

use Closure;

class ExcelMiddle
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
        if ($request->isMethod('GET')) {
            return $next($request);
        }
        if ($request->file('fileup')!=null) {
            return $next($request);
        }
        return redirect('/excel')
        ->with('fileError','You may select a file dude!');
    }
}
