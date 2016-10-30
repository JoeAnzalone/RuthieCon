<?php

namespace App\Http\Middleware;

use Closure;

class ForceHTTPS
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
        if (!$request->secure() && config('app.force_https')) {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
