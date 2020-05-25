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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/session/create', 'SessionController@create');
Route::post('/session/create', 'SessionController@store');

Route::get('/session/join/{session?}', 'SessionController@index');
Route::post('/session/join', 'SessionController@join');

Route::get('/session/{session}', 'SessionController@show');

Route::post('/roll/create', 'RollController@store');
Route::get('/rolls', 'RollController@index');

Route::get('/users', 'SessionController@users');
