<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //
    public function host(){
      return $this->belongsTo('App\Host');
    }
}
