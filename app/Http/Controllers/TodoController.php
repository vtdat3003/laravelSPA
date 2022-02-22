<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $todos = Todo::orderBy('id', 'ASC')->get();
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
        $newTodo = new Todo;
        //dd($request);
        $newTodo->content = $request->todo['content'];
        $newTodo->user_id = $request->todo['user_id'];
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
        $todo = Todo::find($id);
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
        $todo = Todo::find($id);
        if($todo)
        {
            $todo->delete();
            return 'item deleted';
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
