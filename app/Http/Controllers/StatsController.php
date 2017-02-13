<?php

namespace App\Http\Controllers;

use Auth;
// use Redis;
use Validator;
use Carbon\Carbon;
use Service\Stats\Data;

class StatsController extends ApiController
{
    public function get($mf, $yf, $mt, $yt)
    {
    	if ($this->validateRequest($mf, $yf, $mt, $yt)) return $this->respondWithUserError('Please correct the dates');

    	$first = Auth::user()->times()->first()->created_at->startOfMonth();
    	$start = Carbon::create($yf, $mf, 1, 0, 0, 0)->startofMonth();
    	$end = Carbon::create($yt, $mt, 1, 0, 0, 0)->endofMonth();

    	if($first > $start) return $this->respondWithUserError('No data available.');

  //   	$redis = Redis::connection();
  //   	$redis_name = Auth::user()->email.$mf.$mt;
		// $stats = $redis->get($redis_name);
		// if($stats != null) return $this->respondSuccessWithArray(json_decode($stats));

		$days = $end->diffInDays($start);
		$days++;
		$user = Auth::user()->with(array('times' => function($q) use ($start, $end) {
			$q->where('created_at', '>', $start)->where('created_at', '<', $end);
		}, 'times.prayer'))->first();	

		$data = new Data();
		$stats = $data->get($user->times, $days);
		// $redis->set($redis_name, json_encode($stats));

		return $this->respondSuccessWithArray($stats);
    }

	/**
	 * @var month int
	 * @var year int
	 * Validates month and year are valid
	 */
	public function validateRequest($mf, $yf, $mt, $yt) 
	{
		$validator = Validator::make(array('mf' => $mf, 'yf' => $yf, 'mt' => $mt, 'yt' => $yt), [
            'mf' => 'required|numeric|max:2',
            'mt' => 'required|numeric|max:2',
            'yf' => 'required|numeric|between:2013,2018',
            'yt' => 'required|numeric|between:2013,2018',
        ]);

        return $validator->fails();
	}
}
