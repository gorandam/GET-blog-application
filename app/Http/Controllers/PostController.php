<?php

namespace App\Http\Controllers;

use App\Post;// We use it to import post model
use Illuminate\Http\Request;

use  App\Http\Requests;
use Illuminate\Session\Store;// Here we use this namespade to DI and resolve this service from laravel container

class PostController extends Controller
{
    // This is the method to display our retrieved data (posts) from session
    public function getIndex(Store $session) {
      $post = new Post();
      $posts = $post->getPosts($session);// Here we call our Model object method to check if we store data in session and retrive that data(nested enumerated array) and save it in the variable
      return view('blog.index', ['posts' => $posts]);// here we retrun View response object and pased retrived data to the our view
    }

    // This is the method to display all our posts for the admin
    public function getAdminIndex(Store $session) {
      $post = new Post();
      $posts = $post->getPosts($session);// Here we call our Model object method to check if we store data in session and retrive that data(nested enumerated array) and save it in the variable
      return view('admin.index', ['posts' => $posts]);// here we retrun View response object and pased retrived data to the our view
    }

    // This is the method to acess and display single post
    public function getPost(Store $session, $id) {
      $post = new Post();
      $post = $post->getPost($session, $id);// Here we call our Model object method to retrieve single post and save it to the variable
      return view('blog.post', ['post' => $post]);// here we retrun View response object and pased retrived data to the our view
    }
     // Here are ADMIN methods
    // This is the method that allows admin to create new post
    public function getAdminCreate() {
      return view('admin.create'); // This returns admin create template to create posts by admin
    }

    // This is the method that allows admin to edit post
    public function getAdminEdit(Store $session, $id) {
      $post = new Post();
      $post = $post->getPost($session, $id);// Here we call our Model object method to retrieve single post that we want to edit and save it to the variable
      return view('admin.edit', ['post' => $post, 'postId' => $id]);// here we retrun View response object and pased retrived data to the our view
    }

    // This is the method triggered when user (admin) submits our admin.create
    public function postAdminCreate(Store $session, Request $request) {
      $this->validate($request, [ // Here we place our validation logic
        'title' => 'required|min:5',
        'content' => 'required|min:10'
      ]);
      $post = new Post();
      $post = $post->addPost($session, $request->input('title'), $request->input('content')); // Here we use $request->input() method to retrieve users inpit from request
      return redirect()->route('admin.index')->with('info', 'Post created, Title is: ' . $request->input('title'));// Here we return Redirect HTTP header object with specified url
    }

    //This is the method triggered when user (admin) submits admin.edit form
    public function postAdminUpdate(Store $session, Request $request) {
      $this->validate($request, [ // Here we place our validation logic
        'title' => 'required|min:5',
        'content' => 'required|min:10'
      ]);
      $post = new Post();
      $post = $post->editPost($session, $request->input('id'), $request->input('title'), $request->input('content')); // Here we use $request->input() method to retrieve users inpit from request
      return redirect()->route('admin.index')->with('info', 'Post edited, new Title is: ' . $request->input('title'));
    }





}
