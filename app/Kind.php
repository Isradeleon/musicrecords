<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kind extends Model
{
    public $timestamps = false;

    public function albums(){
    	return $this->hasMany('App\Album');
    }
}
