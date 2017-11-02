<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class JohnMiddleware
{
    /**
     * Handle an incoming request.
     * Auto login john.
     * Only for quiz purpose.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Auth::loginUsingId(1); //John user id 1
        return $next($request);
    }
}
