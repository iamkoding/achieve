<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class SettingController extends ApiController
{
    
    public function vibrate()
    {
    	$user = Auth::user();
    	$vibrate = ($user->vibrate ? false : true);
    	$user->vibrate = $vibrate;
    	return $this->databaseSave($user->save());
    }
}
