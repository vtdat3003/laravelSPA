<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Oauth_access_token;
use App\Models\Todo;
use Auth;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        if(Auth::user()->role == 'admin')
        {
            $todos = Todo::orderBy('id', 'ASC')->get();
        }
        else
        {
            $todos = Todo::where('user_id', Auth::user()->id)->orderBy('id', 'ASC')->get();
        }
        return $todos;
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
        $id = User::where('id', $oat->user_id)->get()[0]->id;
        $newTodo = new Todo;
        $newTodo->content = $request->todo['content'];
        $newTodo->user_id = $id;
        $newTodo->save();

        return $newTodo;
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
        $oat = Oauth_access_token::where('id', substr($_COOKIE['authorize'], 7))->get()[0];
        $user = User::where('id', $oat->user_id)->get()[0];
        $todo = Todo::find($id);
        if($user->id == $todo->user_id || $user->role == 'admin')
        {
            if($todo)
            {
                $todo->content = $request->todo["content"];
                if($request->changeStatus)
                {
                    $todo->status = ($todo->status == "done") ? "undone" : "done";
                }
                else
                {
                    $todo->content = $request->todo["content"];
                }
                $todo->save();
                return $todo;
            }
        }

        return 'item not found';
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
        $todo = Todo::find($id);
        if($user->id == $todo->user_id || $user->role == 'admin')
        {
            if($todo)
            {
                $todo->delete();
                return 'item deleted';
            }
        }
        return 'item not found';
    }

    public function done($id)
    {
        $todo = Todo::find($id);
        if($todo)
        {
            if($todo->status == 'undone')
            {
                $todo->status = 'done';
            } 
            else
            {
                $todo->status = 'undone';
            }
            $todo->save();
            return 'status changed';
        }
        return 'item not found';
    }
}
