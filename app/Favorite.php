<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    public $timestamps = false;

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function song(){
    	return $this->belongsTo('App\Song');
    }
}
