<?php

namespace Service\Prayers;

use Log;

class TimesParamException extends \Exception
{
	public function __construct($message) {
		parent::__construct($message, 0, NULL);
		Log::alert("Timing Controller => prayer times get from muslimsalat => ".$message);
	}    
}
