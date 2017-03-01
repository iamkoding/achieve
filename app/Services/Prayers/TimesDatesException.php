<?php

namespace Service\Prayers;

use Log;
use Auth;

class TimesDatesException extends \Exception
{
	public function __construct($url, $error) {
		Log::alert("Timing Controller => prayer times get from muslimsalat => Can't access time table ".$url.' error: '.$error. ' user: '. Auth::user()->id . ' ipaddress:' . $_SERVER['REMOTE_ADDR']);
		parent::__construct('No data received, try again later.', 0, NULL);
	}    
}
