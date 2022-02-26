<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'ASC')->get();
        return $users;
    }

    public function getRole(Request $request)
    {
        $user = User::find($request->id);
        return $user->role;
    }
}
