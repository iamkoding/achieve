<?php

namespace App\Http\Controllers;

use Log;
use Distance;
use Exception;
use Illuminate\Http\Request;
use App\Events\DistanceReceived;
use App\Distance as DistanceModel;
use App\Http\Requests\GetDistanceRequest;

class DistanceController extends ApiController
{
	
	public function index(GetDistanceRequest $request)
	{
		$distances = DistanceModel::getWhereIp($request->ip());

		if($distances->count()) {
			return $this->respondSuccessWithArray($distances);
		}

		try {
			$distances = Distance::get($request->lat, $request->lng);

			$distance = DistanceModel::create([
				'ipaddress' => $request->ip()
			]);

			foreach($distances as $mosque) {
				event(new DistanceReceived($mosque, $distance));
			}

		} catch (Exception $e) {
			return $this->respondWithUserError($e->getMessage());	

		}

		return $this->respondSuccessWithArray(DistanceModel::getWhereIp($request->ip()));
	}    
}
