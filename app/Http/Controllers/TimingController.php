<?php

namespace App\Http\Controllers;

use Auth;
use Exception;
use Validator;
use App\Time;
use App\Prayer;
use Service\Prayers\Times;
use App\Events\TimeReceived;
use Illuminate\Http\Request;
use App\Http\Requests\GetTimingRequest;
use App\Http\Requests\StoreTimingRequest;

class TimingController extends ApiController
{
	public function get($month,$year)
	{
		$validator = Validator::make(array('month' => $month, 'year' => $year), [
            'month' => 'required|numeric|max:2',
            'year' => 'required|numeric|between:2013,2018',
        ]);

        if ($validator->fails()) return $this->respondWithUserError('Please correct the dates');

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

		return $this->respondSuccessWithArray($times);
	}

	public function store(StoreTimingRequest $request)
	{
		Auth::user()->times()->sync([$request->time_id], false);
		return $this->respondSuccessWithArray(array('Time saved' => true));
	}

	public function destroy($id)
	{
		$time = Time::getWithIdAndUser($id, Auth::user()->id);

        if (!$time->users->count()) return $this->respondWithUserError('Time is not associated with user.');

        if(Auth::user()->times()->detach($id)) {
			return $this->respondSuccessWithArray(array('Time deleted' => true));
		}

		return $this->respondInternalError();	
	}    
}
