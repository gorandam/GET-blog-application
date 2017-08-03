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

    // Here we define mutators and accessors
    //Mutator
    public function setTitleAttribute($value) { // This mutator will be automatically called when we attempt to set the value of the title property
      $this->attributes['title'] = strtolower($value);// This will save set value in the Eloquent model internal $attributes property
    }
    //Accessor
    public function getTitleAttribute($value) { // This accessor will automatically be called by Eloquent when attempting to retrieve the value of the title property
      return strtoupper($value);
    }
}
