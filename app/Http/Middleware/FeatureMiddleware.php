<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class FeatureMiddleware
{
    private function userHasFeature(Array $feautres)
    {
        $featureIds = Auth::user()->features()->pluck('slug')->toArray();
        return count(array_intersect($feautres, $featureIds)) == count($feautres);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $routeActions = $request->route()->getAction();

        if (array_key_exists('features', $routeActions)) {
            $routeFeatures = $routeActions['features'];
            if ($this->userHasFeature($routeFeatures)) {
                return $next($request);
            }
        }

        return redirect()->route('home')->with('upgrade_msg', 'To access this feature you need to upgrade your account.');
    }
}
