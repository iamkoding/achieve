<?php

namespace Service\Prayers;

use Config;

class Times {

	/**
	 * @var month int
	 * @var year int
	 * Fire api and retrieve results, results->status_code will be 0 if something is wrong
	 */
	public static function get($city, $month, $year) 
	{
		$token = Config::get('salat.key');

		$url = "http://muslimsalat.com/$city/monthly/01-$month-$year/true.json?key=$token";
		$result = json_decode(file_get_contents($url));
		
		if($result === null) {
			throw new TimesNullException($url);
		} else if($result->status_code === 101) {
			throw new TimesDatesException($url, $result->status_error->invalid_date);
		} else if(!$result->status_code) {
			throw new TimesParamException($result->status_error->invalid_query);
		}

		return $result;
	}
}