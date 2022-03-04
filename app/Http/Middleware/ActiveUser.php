<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Oauth_access_token;
use Redirect;
use Auth;

class ActiveUser
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
        if(array_key_exists("authorize", $_COOKIE))
        {
            $oats = Oauth_access_token::where('id', substr($_COOKIE['authorize'], 7))->get();
            if(count($oats) > 0)
            {
                $user = User::where('id', $oats[0]->user_id)->get()[0];
                if($user)
                {
                    if($user->active == true)
                    {
                        return $next($request);
                    }
                }
                unset($_COOKIE['authorize']);
                return response()->view('unauthorize')->setStatusCode(401);
            }
        }
        //return $next($request);
        return response()->view('unauthorize');
    }
}
