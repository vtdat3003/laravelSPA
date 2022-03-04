<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('home', function(){
    return view('home');
})->name('home');

Route::get('', function(){
    return view('unauthorize');
});

Route::group(['middleware' => 'active'], function(){
    Route::group(['middleware' => ['auth']], function () { 
        Route::get('/todos', function () {
            return view('welcome');
        });
        Route::get('/notis', function () {
            return view('notis');
        });
    });
    
    Route::group(['middleware' => ['auth', 'admin']], function () {   
        Route::get('/users', function () {
            return view('users');
        });
    });
    
});

Route::group(['middleware' => ['guest']], function () { 
    Route::get('/login', function () {
        return view('login');
    });
    Route::get('/register', function () {
        return view('register');
    });
});

// Route::get('/{any?}', function (){
//     return view('welcome');
// })->where('any', '^(?!api\/)[\/\w\.-]*');