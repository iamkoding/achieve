<?php

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

Route::resource('authenticate', 'AuthenticateController', ['only' => ['store']]);
Route::put('authenticate', 'AuthenticateController@authenticate');


Route::group(['middleware' => ['jwt.auth']] , function()
{
	Route::resource('time', 'TimingController', ['only' => ['store','destroy']]);
	Route::get('time/{month}/{year}', 'TimingController@get');
	Route::post('distance', 'DistanceController@index');
	Route::post('vibrate', 'SettingController@vibrate');
});