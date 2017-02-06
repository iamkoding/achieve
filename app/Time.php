<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    protected $fillable = [
    	'datetime','city_id','prayer_id'
    ];

    protected $rules = [
        'city_id' => 'required|exists:cities,id',
        'prayer_id' => 'required|exists:prayers,id',
        'datetime' => 'required|date'
    ];

    private $errors = null;

    public function validate($data)
    {
        $v = \Validator::make($data, $this->rules, $this->messages());
        if ($v->fails())
        {
            $this->errors = $v->errors()->all();
            return false;
        }
        return $v->passes();
    } 

    public function messages()
    {
        return [
            'prayer_id.*' => 'Incorrect prayer',
            'city_id.*' => 'Incorrect city',
            'datetime.*' => 'Incorrect date'
        ];
    }

    public function errors()
    {
        return $this->errors;
    }

    public function city()
    {
    	return $this->hasOne('App\City', 'id');
    }

    public function prayer() 
    {
    	return $this->hasOne('App\Prayer', 'id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
