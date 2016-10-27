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

Route::get('/', 'SessionController@index')->name('session.index');

Route::group(['prefix' => 'session'], function () {
    Route::get('create', 'SessionController@create')->name('session.create');
    Route::post('/', 'SessionController@store')->name('session.store');
    Route::get('/{id}', 'SessionController@show')->name('session.show');
    Route::get('/{id}/edit', 'SessionController@edit')->name('session.edit');
    Route::put('/{id}', 'SessionController@update')->name('session.update');
    Route::delete('/{id}', 'SessionController@destroy')->name('session.destroy');
});


Route::get('/about', function () {
    return view('about.about');
});

Route::get('/privacy', function () {
    return view('about.privacy');
});
