<?php

namespace App\Http\Controllers;

use Auth;
use Exception;
use Validator;
use App\Time;
use App\User;
use App\Prayer;
use Service\Prayers\Times;
use App\Events\TimeReceived;
use Illuminate\Http\Request;
use App\Http\Requests\GetTimingRequest;
use App\Http\Requests\StoreTimingRequest;

class TimingController extends ApiController
{
	/**
	 * @var month int
	 * @var year int
	 * Attempt to get all times with the logged in user
	 * If not exists then fires an api to retrieve all prayer times and then return
	 */
	public function get($month,$year)
	{
        if ($this->validateGetRequest($month, $year)) return $this->respondWithUserError('Please correct the dates');

		$times = Time::getWhereCityWith(Auth::user()->city_id, $month, $year);

		if($times->count()) return $this->respondSuccessWithArray($times);	

		try {
			$times = Times::get($month, $year);
			$prayers = Prayer::get();

			foreach($times->items as $day) {
				event(new TimeReceived($day, $prayers, $city_id));
			}	

			$times = Time::getWhereCityWith($city_id, $month, $year);

		} catch (Exception $e) {
			return $this->respondInternalError('Unable to use this facilty at the moment, please try again later.');	
		}

		return $this->respondSuccessWithArray($times);
	}

	public function saves($month, $year)
	{
		if ($this->validateGetRequest($month, $year)) return $this->respondWithUserError('Please correct the dates');
		$times = User::getSavesForMonth($month, $year, Auth::user()->id);
		return $this->respondSuccessWithArray($times);
	}

	/**
	 * Save a time and user relation
	 */
	public function store(Request $request)
	{
		if(!$this->removeAllAssociatedTimes($request->get('time_id'))) {
			return $this->respondWithUserError('Time does not exist.');
		}

		Auth::user()->times()->sync([$request->time_id], false);
		return $this->respondSuccessWithArray(array('Time saved' => true));
	}

	/**
	 * @var id int
	 * Remove time and user relation
	 */
	public function destroy($id)
	{
		if(!$this->removeAllAssociatedTimes($id)) {
			return $this->respondWithUserError('Time does not exist.');
		}
		return $this->respondSuccessWithArray(array('Time deleted' => true));
	}    

	/**
	 * @var time_id int
	 * @return bool
	 * Delete all associated times from a time with related prayer.
	 */
	private function removeAllAssociatedTimes($time_id) 
	{
		$time = Time::whereId($time_id)->first();

		if(!$time->count()) return false;

		$user = User::getAllTimesFromDatetime($time->datetime, Auth::user()->id, $time->prayer_id);

		foreach($user->times as $time) {
			Auth::user()->times()->detach($time->id);
		}	
		return true;
	}

	/**
	 * @var month int
	 * @var year int
	 * Validates month and year are valid
	 */
	public function validateGetRequest($month, $year) 
	{
		$validator = Validator::make(array('month' => $month, 'year' => $year), [
            'month' => 'required|numeric|max:2',
            'year' => 'required|numeric|between:2013,2018',
        ]);

        return $validator->fails();
	}
}
