<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mosque extends Model
{
    protected $fillable = [
    	'name', 'address', 'city', 'postcode', 'telephone'
    ];
}
