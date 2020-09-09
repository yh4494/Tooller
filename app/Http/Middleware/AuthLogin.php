<?php

namespace App\Http\Middleware;

use App\Http\Config\HttpRouteConfig;
use Closure;
use Illuminate\Support\Facades\Request;

class AuthLogin
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
        $uri = $request->route()->uri();
        $userId = Request::session()->get('user_id');
        if (!$userId && HttpRouteConfig::includeRoute($uri)) {
            return redirect('/login');
        }
        return $next($request);
    }
}
