<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public function post() {// here is post sinngular - one like has one post...
      return $this->belongsTo('App\Post');
    }
}
