<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'name'
    ];

    protected $hidden = [
    	'deleted_at'
    ];

    public function user()
    {
    	return $this->hasOne('App\User');
    }

    public function times()
    {
    	return $this->hasMany('App\Time');
    }

    public static function getCitiesWithUser($user_id)
    {
        return City::with(array('user' => function($q) use ($user_id) {
            $q->whereId($user_id);
        }))->get();
    }
}
