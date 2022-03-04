<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Noti;
use App\Models\Oauth_access_token;
use App\Models\User;

class NotiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $oat = Oauth_access_token::where('id', substr($_COOKIE['authorize'], 7))->get()[0];
        $user = User::where('id', $oat->user_id)->get()[0];
        if($user->role == 'admin')
        {
            $notis = Noti::orderBy('id', 'ASC')->get();
        }
        else
        {
            $notis = Noti::where('user_id', $user->id)->orderBy('id', 'ASC')->get();
        }
        return $notis;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $oat = Oauth_access_token::where('id', substr($_COOKIE['authorize'], 7))->get()[0];
        $user = User::where('id', $oat->user_id)->get()[0];
        if($user->role == 'admin')
        {
            $noti = new Noti;
            $noti->user_id = $request->user_id;
            $noti->content = $request->content;
            $noti->save();
            return $noti;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $oat = Oauth_access_token::where('id', substr($_COOKIE['authorize'], 7))->get()[0];
        $user = User::where('id', $oat->user_id)->get()[0];
        $noti = Noti::find($id);
        if($noti)
        {
            if($noti->user_id == $user->id)
            {
                $noti->delete();
                return 'noti deleted';
            }
            return 'can not delete this noti';
        }
        return 'noti not found';
    }
}
