<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prayer extends Model
{
    protected $fillable = [
    	'name'
    ];

    public function time()
    {
    	return $this->belongsTo('App\Time');
    }
}
