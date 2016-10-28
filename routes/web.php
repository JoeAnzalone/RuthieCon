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

Route::get('/welcome', 'WelcomeController@index')->name('welcome.index');

Route::get('/login', 'FacebookController@login');
Route::get('/facebook/callback', 'FacebookController@callback')->name('facebook.callback');

Route::get('/', 'SessionController@index')->name('sessions.index');

Route::group(['prefix' => 'session'], function () {
    Route::get('create', 'SessionController@create')->name('sessions.create');
    Route::post('/', 'SessionController@store')->name('sessions.store');
    Route::get('/{id}', 'SessionController@show')->name('sessions.show');
    Route::get('/{id}/edit', 'SessionController@edit')->name('sessions.edit');
    Route::put('/{id}', 'SessionController@update')->name('sessions.update');
    Route::delete('/{id}', 'SessionController@destroy')->name('sessions.destroy');
});


Route::get('/about', function () {
    return view('about.about');
});

Route::get('/privacy', function () {
    return view('about.privacy');
});
