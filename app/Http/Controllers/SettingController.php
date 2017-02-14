<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Exception;
use App\City;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateCitySettingRequest;
use App\Http\Requests\UpdatePasswordSettingRequest;

class SettingController extends ApiController
{
    
	/**
	 * Switch vibrate setting 
	 */
    public function updateVibrate()
    {
    	try {
			$user = Auth::user();
	    	$vibrate = ($user->vibrate ? false : true);
	    	$user->vibrate = $vibrate;
	    	$user->save();
	    	return $this->respondSuccessWithArray(array('success' => true));
    	} catch(Exception $e) {
    		return $this->respondInternalError();
    	}
    }

    /**
     * Update city setting for user
     */
    public function updateCity(UpdateCitySettingRequest $request)
    {
    	try {
    		$user = Auth::user();
	    	$user->city_id = $request->city_id;
	    	$user->save();
	    	return $this->respondSuccessWithArray(array('success' => true));
    	} catch(Exception $e) {
    		return $this->respondInternalError();
    	}
    }

    /**
     * Update user password, check if both passwords are the same then update with new password
     */
    public function updatePassword(UpdatePasswordSettingRequest $request) 
    {
    	try {
    		$user = Auth::user();
    		if(Hash::check($request->password, $user->password)) {
    			$user->password = Hash::make($request->password);
    			$user->save();
		    	return $this->respondSuccessWithArray(array('success' => true));
			}
			return $this->respondWithUserError('Incorrect password.');

    	} catch (Exception $e) {
    		return $this->respondInternalError();
    	}
    }

    /**
     * Gets all cities and related logged in user.
     */
    public function get()
    {   
        try {
            $cities = City::getCitiesWithUser(Auth::user()->id);
        } catch (Exception $e) {
            return $this->respondInternalError();
        }
        
        return $this->respondSuccessWithArray();

    }
}
