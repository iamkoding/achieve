<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TimingController extends Controller
{
	public function get()
	{
		dd(\Auth::user()->with(array('times', 'times.prayer','times.city'))->get());
	}

	public function store($city_id, $prayer_id)
	{
		$time = new \App\Time;
		$time_array = array(
			'city_id' => $city_id,
			'prayer_id' => $prayer_id,
			'datetime' => \Carbon\Carbon::now()
		);

		if(!$time->validate($time_array)) {
			return array('success' => false, 'message' => $time->errors());
		}

		$time->city_id = $city_id;
		$time->prayer_id = $prayer_id;
		$time->datetime = \Carbon\Carbon::now();


		if(\Auth::user()->times()->save($time)) {
			return array('success' => true);
		}
		return array('success' => false, 'message' => 'Could not save at this time.');	
	}    
}
