<?php

namespace App\Http\Controllers;

use App\Post;// We use it to import post model
use Illuminate\Http\Request;

use  App\Http\Requests;
use Illuminate\Session\Store;// Here we use this namespade to DI and resolve this service from laravel container

class PostController extends Controller
{
    public function getIndex(Store $session) {
      $post = new Post();
      $posts = $post->getPosts($session);// Here we call our Model object method to check if we store data in session and retrive that data(nested enumerated array) and save it in the variable
      return view('blog.index', ['posts' => $posts]);// here we retrun View response object and pased retrived data to the our view
    }
}
