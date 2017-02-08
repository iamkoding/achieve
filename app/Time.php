<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    protected $fillable = [
    	'datetime','city_id','prayer_id'
    ];

    public function city()
    {
    	return $this->hasOne('App\City', 'id');
    }

    public function prayer() 
    {
    	return $this->hasOne('App\Prayer', 'id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public static function getWhereCityWith($city_id, $month, $year, array $with)
    {
        return Time::whereCityId($city_id)->where(DB::raw('MONTH(datetime)'),'=', $month)->where(DB::raw('YEAR(datetime)'),'=', $year)->with($with)->get();
    }
}
