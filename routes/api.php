<?php

use Illuminate\Http\Request;

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

// auth
Route::post('register', 'Auth\RegisterController@sign_up')->name('api.register');
Route::post('login', 'Auth\LoginController@sign_in')->name('api.login');

// note
Route::apiResource('user/{id}/notes', 'NoteController');
