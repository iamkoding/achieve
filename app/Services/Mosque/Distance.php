<?php

namespace Service\Mosque;

use Config;

class Distance {

	const INVALID_KEY = 'Invalid Token Key';
	const INVALID_KEY2 = 'Token Key Missing !';
	const INVALID_PARAMS = 'Invalid Parameters';

	public static function get($lat, $lng)
	{
		$token = Config::get('ummah.key');

		$result = file_get_contents("http://ummahnet.com/services/api/masajids/?reqType=latlng&radius=25&lat=$lat&lng=$lng&TOKEN=$token");
		
		if($result === Distance::INVALID_KEY || $result === Distance::INVALID_KEY2) {
			throw new DistanceKeyException;
		} else if ($result === Distance::INVALID_PARAMS) {
			throw new DistanceParamsException($lat, $lng);
		} else if($result === 'null') {
			throw new DistanceEmptyException($lat, $lng);
		} 	

		return json_decode($result, true);	
	}
	
}