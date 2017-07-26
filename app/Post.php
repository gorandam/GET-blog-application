<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    // This is the code that give us opportunity to populate our table in one step - mass-assaingable
    protected $fillable = ['title', 'content'];
    
    // This is the method to get our posts from the session
    public function getPosts($session) {
      if (!$session->has('posts')) { // Here we check to see if  our session has variable posts
        $this->createDumyData($session);
      }
      return $session->get('posts');
    }
    // This is the method to retrieve our single post from session array
    public function getPost($session, $id) {
      if (!$session->has('posts')) { // Here we check to see if  our session has variable posts
        $this->createDumyData($session);
      }
      return $session->get('posts')[$id];
    }

    // This is the method to add one post to our session array
    public function addPost($session, $title, $content) {
      if (!$session->has('posts')) { // Here we check to see if  our session has variable posts
        $this->createDumyData($session);
      }
      $posts = $session->get('posts');// Here we get post array from our session
      array_push($posts, ['title' => $title, 'content' => $content]);// Here we push our input to sessions array
      $session->put('posts', $posts);
    }

    // This is method to edit out post in the session array
    public function editPost($session, $id, $title, $content) {
      $posts = $session->get('posts');// Here we get post array from our session
      $posts[$id] = ['title' => $title, 'content' => $content];// Here we edit named post id
      $session->put('posts', $posts);// Here we put our new edit post in the session
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
