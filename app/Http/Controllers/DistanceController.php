<?php

namespace App\Http\Controllers;

use Log;
use Distance;
use Exception;
use Illuminate\Http\Request;
use App\Events\DistanceReceived;
use App\Distance as DistanceModel;
use App\Http\Requests\GetDistanceRequest;
use Service\Mosque\DistanceEmptyException;

class DistanceController extends ApiController
{
	
	/**
	 * Retrieves all mosques if a geo location is found in the database.
	 * Else fire api to retrieve closest mosques
	 */
	public function index(GetDistanceRequest $request)
	{
		$distances = DistanceModel::getWhereGeo($request->lat, $request->lng);

		if($distances->count()) {
			return $this->respondSuccessWithArray($distances);
		}

		try {
			$distances = Distance::get($request->lat, $request->lng);

			$distance = DistanceModel::create([
				'lat' => $request->lat,
				'lng' => $request->lng
			]);

			foreach($distances as $mosque) {
				event(new DistanceReceived($mosque, $distance));
			}

		} catch (DistanceEmptyException $e) {
			return $this->respondWithUserError('Unable to find anything near you. Please try a different location.');	
		} catch (Exception $e) {
			return $this->respondWithInternalError();	
		}

		return $this->respondSuccessWithArray(DistanceModel::getWhereGeo($request->lat, $request->lng));
	}    
}
