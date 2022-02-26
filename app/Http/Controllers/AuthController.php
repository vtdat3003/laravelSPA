<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\User;
use App\Models\Oauth_access_token;

class AuthController extends Controller
{
    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password'  => 'required|min:6|confirmed',
        ]);
        if ($v->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Login user and return a token
     */
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->get()[0];
        //dd($user->id);
        $credentials = $request->only('email', 'password');
        if ($token = $this->guard()->attempt($credentials)) {
            $uid = Auth::user()->id;
            $oats = Oauth_access_token::where('user_id', $uid)->get();
            foreach($oats as $oat)
            {
                $oat->delete();
            }
            $oat = new Oauth_access_token();
            $oat->id = $token;
            $oat->user_id = $user->id;
            $oat->revoked = false;
            $oat->save(); 
            return response()->json(['status' => 'success'], 200)->header('Authorization', 'Bearer ' . $token);
        }
        return response()->json(['error' => 'login_error'], 401);
    }

    /**
     * Logout User
     */
    public function logout(Request $request)
    {
        $uid = Auth::user()->id;
        $oats = Oauth_access_token::where('user_id', 1)->get();
        foreach($oats as $oat)
        {
            $oat->delete();
        }
        $this->guard()->logout();
        //return redirect('/login');
        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }

    /**
     * Get authenticated user
     */
    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    /**
     * Refresh JWT token
     */
    public function refresh()
    {
        dd(Auth::user());
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'successs'], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['error' => 'refresh_token_error'], 401);
    }

    /**
     * Return auth guard
     */
    private function guard()
    {
        return Auth::guard();
    }
}