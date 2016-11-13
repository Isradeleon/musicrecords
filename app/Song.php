<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    public $timestamps = false;

    public function album(){
    	return $this->belongsTo('App\Album');
    }

    public function favorites(){
    	return $this->hasMany('App\Favorite');
    }
}
