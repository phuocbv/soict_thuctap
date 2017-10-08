<?php

namespace App\Http\Middleware;

use Closure;

class Lecture
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
        if (($request->session()->has('lectureLogin')) == false) {
            return redirect('login');
        } else {
            return $next($request);
        }
    }
}
