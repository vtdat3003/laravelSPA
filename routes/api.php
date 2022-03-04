<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotiController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('auth')->group(function () {
    // Below mention routes are public, user can access those without any restriction.
    // Create New User
    Route::post('register', [AuthController::class, 'register']);
    // Login User
    Route::post('login', [AuthController::class, 'login']);
    
    // Refresh the JWT Token
    Route::get('refresh', [AuthController::class, 'refresh']);
    
    // Below mention routes are available only for the authenticated users.
    Route::middleware('auth:api')->group(function () {
        // Get user info
        Route::get('user', [AuthController::class, 'user']);
        // Logout user from application
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

Route::group(['middleware' => 'active'], function(){
    Route::middleware('auth:api')->group(function () {
        Route::get('todos', [TodoController::class, 'index']);
        Route::post('todo/store', [TodoController::class, 'store']);
        Route::put('todo/{id}', [TodoController::class, 'update']);
        Route::put('todo/done/{id}', [TodoController::class, 'done']);
        Route::delete('todo/{id}', [TodoController::class, 'destroy']);

        Route::get('notis', [NotiController::class, 'index']);
        Route::delete('noti/{id}', [NotiController::class, 'destroy']);
    });
    //Route::get('todos', [TodoController::class, 'index']);
    //Route::get('users', [UserController::class, 'index']);

    Route::middleware(['auth:api', 'admin'])->group(function () {
        Route::get('users', [UserController::class, 'index']);
        Route::post('getRole', [UserController::class, 'getRole']);
        Route::post('user/{id}', [UserController::class, 'update']);
        Route::delete('user/{id}', [UserController::class, 'destroy']);

        Route::post('noti/store', [NotiController::class, 'store']);
    });
});
//Route::delete('noti/{id}', [NotiController::class, 'destroy']);