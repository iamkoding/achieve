<?php

namespace Service\Prayers;

use Config;

class Times {

	public static function get($month, $year) 
	{
		$token = Config::get('salat.key');

		$result = json_decode(file_get_contents("http://muslimsalat.com/manchester/monthly/01-$month-$year/true.json?key=$token"));

		if(!$result->status_code) {
			throw new TimesParamException($result->status_error->invalid_query);
		}

		return $result;
	}
}