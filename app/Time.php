<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    protected $fillable = [
    	'datetime'
    ];

    public function city()
    {
    	return $this->hasOne('App\City', 'city_id');
    }

    public function prayer() 
    {
    	return $this->hasOne('App\Prayer', 'prayer_id');
    }
}
