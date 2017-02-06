<?php

namespace Service\Mosque;

use Log;

class DistanceKeyException extends \Exception
{
	public function __construct() {
		parent::__construct('System Error', 0, NULL);
		Log::alert("Distance Controller => Distance token key is incorrect");
	}    
}
