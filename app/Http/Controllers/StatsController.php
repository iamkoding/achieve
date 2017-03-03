<?php

namespace App\Http\Controllers;

use Auth;
// use Redis;
use Validator;
use Carbon\Carbon;
use Service\Stats\Data;

class StatsController extends ApiController
{
	/**
	 * Get stats for user between certain times
	 * @var mf int
	 * @var yf int
	 * @var mt int
	 * @var mt int
	 * @return array
	 */
    public function get($mf, $yf, $mt, $yt)
    {
    	if ($this->validateRequest($mf, $yf, $mt, $yt)) return $this->respondWithUserError('Please correct the dates');

    	$time = Auth::user()->times()->first();
    	if($time === null) return $this->respondWithUserError("You don't have any stats available for this month yet. Please try again later...");

    	$first = $time->created_at->startOfMonth();
    	$start = Carbon::create($yf, $mf, 1, 0, 0, 0)->startofMonth();
    	$end = Carbon::create($yt, $mt, 1, 0, 0, 0)->endofMonth();

    	if($first > $start) return $this->respondWithUserError('No data available.');

		$days = $end->diffInDays($start);
		$days++;
		$user = $this->getTimesBetweenDates($start, $end);	

		$data = new Data();
		$stats = $data->get($user->times, $days);

		return $this->respondSuccessWithArray($stats);
    }

	/**
	 * @var month int
	 * @var year int
	 * Validates month and year are valid
	 */
	private function validateRequest($mf, $yf, $mt, $yt) 
	{
		$validator = Validator::make(array('mf' => $mf, 'yf' => $yf, 'mt' => $mt, 'yt' => $yt), [
            'mf' => 'required|numeric|between:1,12',
            'mt' => 'required|numeric|between:1,12',
            'yf' => 'required|numeric|between:2017,2026',
            'yt' => 'required|numeric|between:2017,2026',
        ]);

        return $validator->fails();
	}

	/**
	 * Return times between dates
	 * @var start Carbon date
	 * @var end Carbon date
	 * @return array
	 */
    private function getTimesBetweenDates($start, $end)
    {
        return Auth::user()->with(array('times' => function($q) use ($start, $end) {
            $q->where('created_at', '>', $start)->where('created_at', '<', $end);
        }, 'times.prayer'))->first();
    }
}
