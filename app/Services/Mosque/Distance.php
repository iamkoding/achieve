<?php

namespace Service\Mosque;

class Distance {

	const INVALID_KEY = 'Invalid Token Key';
	const INVALID_PARAMS = 'Invalid Parameters';

	public static function get()
	{
		$result = file_get_contents("http://ummahnet.com/services/api/masajids/?reqType=latlng&radius=25&lat=32.720660255324255&lng=-96.80097192907867&TOKEN=TEST");

		if($result === Distance::INVALID_KEY) {
			throw new DistanceKeyException;
		} else if ($result === Distance::INVALID_PARAMS) {
			throw new DistanceParamsException;
		} 	

		return json_decode($result, true);	
	}
	
}