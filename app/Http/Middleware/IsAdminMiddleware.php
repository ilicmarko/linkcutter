<?php

namespace App\Http\Middleware;

use Closure;
use \Auth;
use Illuminate\Support\Facades\Log;

class IsAdminMiddleware
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
        if (Auth::user() && Auth::user()->admin === 1) {
            return $next($request);
        }

        Log::critical('Someone tried to access the admin panel.', [
            'IP'        => $request->ip(),
            'Browser'   => $request->server('HTTP_USER_AGENT'),
            'Referer'  =>$request->server('HTTP_REFERER'),
        ]);
        return redirect('/');
    }
}
