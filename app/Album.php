<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    public $timestamps = false;

    public function artist(){
    	return $this->belongsTo('App\Artist');
    }

    public function kind(){
    	return $this->belongsTo('App\Kind');
    }

    public function songs(){
    	return $this->hasMany('App\Song');
    }

    public function images(){
    	return $this->hasMany('App\Image');
    }
}
