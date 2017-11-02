<?php

namespace App\Http\Middleware;

use Closure;
use Response;

class AdminMiddleware
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
        if(!$this->isAdmin($request)){
            return Response::json([
                'code'      =>  403,
                'message'   =>  'Forbidden'
            ], 403);
        }
        
        return $next($request);
    }

    private function isAdmin($request){
        return $request->header('x-auth-key') && $request->header('x-auth-key') == 'Zioj23D92j2kGf9D';
    }
}
