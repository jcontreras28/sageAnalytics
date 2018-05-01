<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AccessMiddleware
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
        $pubId = $request->id;
        if (!Auth::check()) {
            return redirect('/');
        }

        if ((Auth::user()->role_id != 1) && (Auth::user()->publication_id != $pubId)) {
            return redirect('/');
        }

        return $next($request);
    }
}
