<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
    	'name'
    ];

    public function user()
    {
    	return $this->hasMany('App\User');
    }

    public function times()
    {
    	return $this->hasMany('App\Time');
    }
}
