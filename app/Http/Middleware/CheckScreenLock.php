<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckScreenLock
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!empty(session()->get('screenLocked')) or session()->get('screenLocked') === 'YES')
        {
            return redirect('locked-screen');
        }
        return $next($request);
    }
}
