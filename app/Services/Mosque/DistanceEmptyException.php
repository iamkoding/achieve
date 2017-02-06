<?php

namespace Service\Mosque;

use Log;

class DistanceEmptyException extends \Exception
{
	public function __construct($lat, $lng) {
		parent::__construct('No Results Found', 0, NULL);
		Log::notice("Distance Controller => Distance no results found", ['lat' => $lat, 'lng' => $lng]);
	}
}
