<?php

namespace App\Http\Controllers;

use Log;
use Distance;
use Illuminate\Http\Request;
use App\Events\DistanceReceived;
use Exception;

class DistanceController extends Controller
{
	
	public function index($lat, $lng, Request $r)
	{
		$distances = \App\Distance::getWhereIp($r->ip());
		if($distances->count()) {
			return json_encode(array('success' => true, 'result' => $distances));
		}

		try {
			$distances = Distance::get($lat, $lng);

			$distance = \App\Distance::create([
				'ipaddress' => $r->ip()
			]);

			foreach($distances as $mosque) {
				event(new DistanceReceived($mosque, $distance));
			}

		} catch (Exception $e) {
			return array('success' => false, 'message' => $e->getMessage());	

		}

		return json_encode(array('success' => true, 'result' => \App\Distance::getWhereIp($r->ip())));
	}    
}
