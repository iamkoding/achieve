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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
Route::post('authenticate', 'AuthenticateController@authenticate');


Route::group(['middleware' => ['jwt.auth']] , function()
{
	Route::get('/timing/{city_id}/{prayer_id}', 'TimingController@store');
	Route::get('/timing', 'TimingController@get');

	Route::get('/distance/{lat}/{lng}', 'DistanceController@index');
});