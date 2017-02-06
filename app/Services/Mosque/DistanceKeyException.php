<?php

namespace Service\Mosque;

use Log;

class DistanceKeyException extends \Exception
{
	public function __construct($lat, $lng) {
		parent::__construct('System Error', 0, NULL);
		Log::notice("Distance Controller => Distance token key is incorrect");
	}    
}
