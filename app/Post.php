<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // This is the method to get our posts from the session
    public function getPosts($session) {
      if (!$session->has('posts')) { // Here we check to see if  our session has variable posts
        $this->createDumyData($session);
      }
      return $session->get('posts');
    }

    // This is default sessions data method
    private function createDumyData($session) {

      $posts = [
        [
          'title' => 'Learning Laravel',
          'content' => 'This blog post will get you right on the track with Laravel!'
        ],
        [
          'title' => 'Somthing Else',
          'content' => 'Some other content!'
        ]
      ];
      $session->put('posts', $posts); // Here we store this default data in to our session_destroy
   }
}
