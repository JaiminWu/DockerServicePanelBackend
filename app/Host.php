<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Host extends Model
{
    //
    public function containers(){
      return $this->hasMany('App\Container');
    }

    public function images(){
      return $this->hasMany('App\Image');
    }
}
