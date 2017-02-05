<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DistanceMosque extends Model
{
    protected $visible = array('distance');

	protected $table = 'distance_mosque';

    protected $fillable = [
    	'distance', 'distance_id', 'mosque_id'
    ];

}
