<?php

namespace App\Http\Middleware;

use Closure;

class AppMiddleware
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
        setlocale(LC_ALL, 'pt_PT.utf8');
        return $next($request);
    }
}
