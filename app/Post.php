<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    // This is the code that give us opportunity to populate our table in one step - mass-assaingable
    protected $fillable = ['title', 'content'];

  
}
