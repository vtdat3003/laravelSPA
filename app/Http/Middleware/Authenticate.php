<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Support\Arr;
use Auth;
use App\Models\Oauth_access_token;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    // Override handle method
    public function handle($request, Closure $next, ...$guards)
    {
        $request->server->set('HTTP_AUTHORIZATION', $request->cookie('authorize'));
        if ($this->authenticate($request, $guards) === 'authentication_failed') {
            return response()->json(['error'=>'Unauthorized'],400);
        }

        return $next($request)->header('Access-Control-Allow-Origin', 'http://127.0.0.1:8000/')
        ->header('Access-Control-Allow-Methods', '*')
        ->header('Access-Control-Allow-Credentials', 'true')
        ->header('Access-Control-Allow-Headers', 'X-CSRF-Token');
    }
    // Override authentication method
    protected function authenticate($request, array $guards)
    {
        $request->server->set('HTTP_AUTHORIZATION', $_COOKIE["authorize"]);
        if (empty($guards)) {
            $guards = [null];
        }
        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            }
        }
        return 'authentication_failed';
    }
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
