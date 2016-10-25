<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/welcome', 'WelcomeController@index');

Route::get('/login', 'FacebookController@login');
Route::get('/facebook/callback', 'FacebookController@callback');

Route::get('/', 'SessionController@index');
