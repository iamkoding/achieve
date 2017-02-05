<?php

namespace App\Http\Controllers;

use Distance;
use Illuminate\Http\Request;
use Service\Mosque\DistanceKeyException;
use Service\Mosque\DistanceParamsException;

class DistanceController extends Controller
{
	
	public function index(Request $r)
	{
		$distances = \App\Distance::getWhereIp($r->ip());

		if(count($distances) === 0) {
			try {
				$distances = Distance::get();
			} catch (DistanceKeyException $e) {
				return array('success' => false);	
			} catch (DistanceParamsException $e) {
				return array('successs' => false);	
			}
		}
		
		return array('success' => true, 'data' => $distances);
	}    
}
