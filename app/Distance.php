<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distance extends Model
{

    protected $fillable = [
    	'lat','lng'
    ];

    protected $hidden = [
        'lat','lng'
    ];

    public function mosques()
    {
    	return $this->belongsToMany('App\Mosque')->withPivot('distance')->select('mosques.id','name','address','city','postcode','telephone');
    }

    public static function getWhereGeo($lat, $lng)
    {
    	return Distance::whereLat($lat)->whereLng($lng)->with('mosques')->get();
    }
}
