<?php

namespace Service\Prayers;

use Config;

class Times {

	/**
	 * @var month int
	 * @var year int
	 * Fire api and retrieve results, results->status_code will be 0 if something is wrong
	 */
	public static function get($month, $year) 
	{
		$token = Config::get('salat.key');

		$url = "http://muslimsalat.com/manchester/monthly/01-$month-$year/true.json?key=$token";
		$result = json_decode(file_get_contents($url));
		
		if(!$result->status_code) {
			throw new TimesParamException($result->status_error->invalid_query);
		} else if($result === null) {
			throw new TimesNullException($url);
		}

		return $result;
	}
}