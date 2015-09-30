<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'SongsController@index');

Route::post("song/store", 'SongsController@store');
Route::resource("song", 'SongsController');
Route::controller('songs', 'SongsController');

Route::controller('users', 'UsersController');
Route::resource('user', 'UsersController');

Route::controller('ajax', 'AjaxController');

Route::controller('vote', 'VoteController');
