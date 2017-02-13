<?php

namespace Service\Prayers;

use Log;

class TimesNullException extends \Exception
{
	public function __construct($message) {
		parent::__construct('No data received, try again later.', 0, NULL);
		Log::alert("Timing Controller => prayer times get from muslimsalat => Null exception most likely token incorrect or not set ".$url);
	}    
}
