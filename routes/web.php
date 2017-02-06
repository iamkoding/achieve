<?php

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
Auth::login(App\User::first());

Route::get('/timing/{city_id}/{prayer_id}', 'TimingController@store');
Route::get('/timing', 'TimingController@get');

Route::get('/', function() {
	$user = App\User::first();
	$city = App\City::first();
	$prayer = App\Prayer::first();

	$time = $city->times()->create([
		'prayer_id' => $prayer->id,
		'datetime' => Carbon\Carbon::now()
	]);
	// dd($time->users()->attach($user));
	dd($user->times()->attach($time));

});

Route::get('/distance/{lat}/{lng}', 'DistanceController@index');
