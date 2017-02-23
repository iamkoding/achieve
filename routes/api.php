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

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization');

Route::resource('authenticate', 'AuthenticateController', ['only' => ['store']]);
Route::put('authenticate', 'AuthenticateController@authenticate');


Route::group(['middleware' => ['jwt.auth']] , function()
{
	Route::resource('time', 'TimingController', ['only' => ['store','destroy']]);
	Route::get('time/{month}/{year}', 'TimingController@get');
	Route::get('saves/{month}/{year}', 'TimingController@saves');
	Route::post('distance', 'DistanceController@index');
	Route::get('cities', 'SettingController@get');
	Route::post('change-vibrate', 'SettingController@updateVibrate');
	Route::post('change-city', 'SettingController@updateCity');
	Route::post('change-password', 'SettingController@updatePassword');
	Route::get('stats/{month_from}/{year_from}/{month_to}/{year_to}', 'StatsController@get');
});