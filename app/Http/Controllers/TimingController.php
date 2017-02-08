<?php

namespace App\Http\Controllers;

use Auth;
use Exception;
use App\Time;
use App\Prayer;
use Service\Prayers\Times;
use App\Events\TimeReceived;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTimingRequest;

class TimingController extends ApiController
{
	public function get($month, $year)
	{
		//Validate parameters
		$city_id = Auth::user()->city->id;
		$times = Time::getWhereCityWith($city_id, $month, $year, ['prayer', 'users']);

		if($times->count()) return $this->respondSuccessWithArray($times);	

		try {
			$times = Times::get($month, $year);
			$prayers = Prayer::get();

			foreach($times->items as $day) {
				event(new TimeReceived($day, $prayers, $city_id));
			}	

			$times = Time::getWhereCityWith($city_id, $month, $year, ['prayer']);

		} catch (Exception $e) {
			return $this->respondInternalError('Unable to use this facilty at the moment, please try again later.');	
		}

		$x = $this->respondSuccessWithArray($times);
		dd($sdlkf);
	}

	public function store(StoreTimingRequest $request)
	{
		if(Auth::user()->times()->sync([$request->time_id])) {
			return $this->respondSuccessWithArray();
		}
		return $this->respondInternalError();	
	}    

	function when_validating_incoming_times() 
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
	}
}
