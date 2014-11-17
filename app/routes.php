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

Route::resource("song", 'SongsController');

Route::get('ajax/songs', 'AjaxController@songs');
Route::get('ajax/songs/{perPage}', 'AjaxController@songs')->where(array('perPage' => '[0-9]*'));

Route::get('ajax/youtube', 'AjaxController@searchYoutube');
Route::get('ajax/youtube/{results}', 'AjaxController@searchYoutube')->where(array('results' => '[0-9]*'));

Route::get('ajax/spotify', 'AjaxController@searchSpotify');
Route::get('ajax/spotify/{results}', 'AjaxController@searchSpotify')->where(array('results' => '[0-9]*'));

Route::get('ajax/soundcloud', 'AjaxController@searchSoundcloud');
Route::get('ajax/soundcloud/{results}', 'AjaxController@searchSpotify')->where(array('results' => '[0-9]*'));
