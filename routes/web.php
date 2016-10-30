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

Route::get('/login', 'FacebookController@login')->name('facebook.login');
Route::get('/logout', 'FacebookController@logout')->name('facebook.logout');
Route::get('/facebook/callback', 'FacebookController@callback')->name('facebook.callback');

Route::get('/', 'SessionController@index')->name('sessions.index');

Route::group(['prefix' => 'session'], function () {
    Route::get('create', 'SessionController@create')->name('sessions.create');
    Route::post('/', 'SessionController@store')->name('sessions.store');
    Route::get('/{id}', 'SessionController@show')->name('sessions.show');
    Route::get('/{id}/edit', 'SessionController@edit')->name('sessions.edit');
    Route::put('/{id}', 'SessionController@update')->name('sessions.update');
    Route::put('/{id}/vote', 'SessionController@vote')->name('sessions.vote');
    Route::delete('/{id}/vote', 'SessionController@unVote')->name('sessions.unvote');
    Route::get('/{id}/delete', 'SessionController@delete')->name('sessions.delete');
    Route::delete('/{id}', 'SessionController@destroy')->name('sessions.destroy');
});


Route::get('/about', function () {
    return view('about.about');
});

Route::get('/privacy', function () {
    return view('about.privacy');
});
