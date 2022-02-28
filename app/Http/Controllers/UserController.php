<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Oauth_access_token;

class UserController extends Controller
{
    public function index()
    {
        $oat = Oauth_access_token::where('id', substr($_COOKIE['authorize'], 7))->get()[0];
        $user = User::where('id', $oat->user_id)->get()[0];
        if($user->role == 'admin')
        {
            $users = User::orderBy('id', 'ASC')->get();
            return $users;
        }
    }

    public function getRole(Request $request)
    {
        $user = User::find($request->id);
        return $user->role;
    }

    public function update(Request $request)
    {
        $user = User::find($request->id);
        if($user)
        {
            if($user->role == 'admin')
            {
                return 'cannot deactivate admin';
            }
            $user->active = !$user->active;
            $user->save();
            if($user->active == false)
            {
                $oats = Oauth_access_token::where('user_id', $request->id)->get();
                foreach($oats as $oat)
                {
                    $oat->delete();
                }
            }
            return $user;
        }
        return 'user not found';
    }

    public function destroy(Request $request)
    {
        $user = User::find($request->id);
        if($user)
        {
            if($user->role == 'admin')
            {
                return 'cannot delele admin';
            }
            $user->delete();
            $oat = Oauth_access_token::where('user_id', $request->id);
            $oat->delete();
            return 'user deleted';
        }
        return 'user not found';
    }
}
