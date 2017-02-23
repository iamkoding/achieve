<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    protected $fillable = [
    	'datetime','city_id','prayer_id'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public function city()
    {
    	return $this->hasOne('App\City', 'id', 'city_id')->select('name', 'id');
    }

    public function prayer() 
    {
    	return $this->hasOne('App\Prayer', 'id', 'prayer_id')->select('id', 'name');
    }

    public function users()
    {
        return $this->belongsToMany('App\User')->select('name');
    }

    public static function getWhereCityWith($city_id, $month, $year)
    {
        return Time::whereCityId($city_id)->where(DB::raw('MONTH(datetime)'),'=', $month)->where(DB::raw('YEAR(datetime)'),'=', $year)->with('prayer')->get();
    }

    public static function getWithIdAndUser($id, $user_id)
    {
        return Time::whereId($id)->with(array('users' => function($q) use ($user_id) {
            $q->where('user_id', '=', $user_id);
        }))->first(); 
    }
}
