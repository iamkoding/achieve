<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distance extends Model
{

    protected $fillable = [
    	'ipaddress', 'distance'
    ];

    public function mosques()
    {
    	return $this->belongsToMany('App\Mosque')->withPivot('distance');
    }

    public static function getWhereIp($ip)
    {
    	return Distance::whereIpaddress($ip)->with('mosques')->get();
    }
}
