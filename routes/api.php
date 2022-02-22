<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('todos', [TodoController::class, 'index']);
Route::post('todo/store', [TodoController::class, 'store']);
Route::put('todo/{id}', [TodoController::class, 'update']);
Route::put('todo/done/{id}', [TodoController::class, 'done']);
Route::delete('todo/{id}', [TodoController::class, 'destroy']);

Route::get('users', [UserController::class, 'index']);