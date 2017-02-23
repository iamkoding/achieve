<?php

namespace App;

use DB;
use Datetime;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'city_id','vibrate'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'deleted_at',
    ];

    public function city() 
    {
        return $this->hasOne('App\City', 'id');
    }

    public function times()
    {
        return $this->belongsToMany('App\Time');
    }

    public static function getSavesForMonth($month, $year, $user_id)
    {
        return User::whereId($user_id)->select('id')->with(array('times' => function($q) use ($month, $year) {
            $q->where(DB::raw('MONTH(datetime)'),'=', $month)->where(DB::raw('YEAR(datetime)'),'=', $year)->select('times.id', 'datetime', 'prayer_id');
        }))->get();
    }

    public static function getAllTimesFromDatetime($datetime, $user_id, $prayer_id)
    {
        $date = new DateTime($datetime);
        $day = date_format($date, 'd');
        $month = date_format($date, 'm');
        $year = date_format($date, 'Y');

        return User::whereId($user_id)->with(array('times' => function($q) use($day, $month, $year, $prayer_id) {
            $q->where(DB::raw('DAY(datetime)'),'=', $day)->where(DB::raw('MONTH(datetime)'),'=', $month)->where(DB::raw('YEAR(datetime)'),'=', $year)->where('prayer_id', '=', $prayer_id);
        }))->first();
    }

}
