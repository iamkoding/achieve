<?php

namespace Service\Mosque;

use Log;

class DistanceParamsException extends \Exception
{
    public function __construct($lat, $lng) {
		parent::__construct('System P Error', 0, NULL);
		Log::alert("Distance Controller => Distance params are incorrect", ['lat' => $lat, 'lng' => $lng]);
	}   
}
