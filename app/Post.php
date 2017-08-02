<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    // This is the code that give us opportunity to populate our table in one step - mass-assaingable
    protected $fillable = ['title', 'content'];

    // Here we create our database tables reltionship method
    public function likes() {
      return $this->hasMany('App\Like'); //here we define that our posts table has many likes from likes table....
    }

    //Here we define many-to-many relationship method
    public function tags() {
      return $this->belongsToMany('App\Tag')->withTimestamps();
    }

    public function setTitleAttribute($value) {
      $this->attributes['title'] = strtolower($value);
    }
    public function getTitleAttribute($value) {
      return strtoupper($value);
    }
}
