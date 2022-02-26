<?php

namespace App\Http\Middleware;

use App\Models\Oauth_access_token;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Auth;

class AdminOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $oat = Oauth_access_token::where('id', substr($_COOKIE['authorize'], 7))->get()[0];
        $role = User::where('id', $oat->user_id)->get()[0]->role;
        if($role != 'admin')
        {
            return redirect('/home');
        }

        return $next($request);
    }
}
