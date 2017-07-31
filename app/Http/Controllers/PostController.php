<?php

namespace App\Http\Controllers;

use App\Post;// We use it to import post model
use Illuminate\Http\Request;

use  App\Http\Requests;
use Illuminate\Session\Store;// Here we use this namespade to DI and resolve this service from laravel container

class PostController extends Controller
{
    // This is the method to fetch and display our retrieved data (posts) from database
    public function getIndex() {
      $posts = Post::all();//Here we use our eloqent class database query fetch method to fetch data from database in form of collection object.
      return view('blog.index', ['posts' => $posts]);// here we retrun View response object and pased retrived data to the our view
    }

    // This is the method to display all our posts for the admin
    public function getAdminIndex() {
      $posts = Post::all();
      return view('admin.index', ['posts' => $posts]);// here we retrun View response object and pased retrived data to the our view
    }

    // This is the method to acess and display single post at home page
    public function getPost($id) {
      $post = Post::find($id);//Here we use our find fetch method to find single post with this $id
      return view('blog.post', ['post' => $post]);// here we retrun View response object and pased retrived data to the our view
    }
     // Here are ADMIN methods
    // This is the method that allows admin to create new post
    public function getAdminCreate() {
      return view('admin.create'); // This returns admin create template to create posts by admin
    }

    // This is the method that allows admin to edit one post
    public function getAdminEdit($id) {
      $post = Post::find($id);
      return view('admin.edit', ['post' => $post, 'postId' => $id]);// here we retrun View response object and pased retrived data to the our view
    }

    // This is the method triggered when user (admin) submits our admin.create
    public function postAdminCreate(Request $request) {
      //var_dump($request);
      $this->validate($request, [ // Here we place our validation logic
        'title' => 'required|min:5',
        'content' => 'required|min:10'
      ]);
      $post = new Post([
        'title' => $request->input('title'),// Third, we use $request->input method to access to the user input in $request insatnce....
        'content' => $request->input('content')
      ]);// Here we create instance of our Post model = this maps our table in database...
      ///$post->title = .... Here we acess to propery of $post instance,  $post instance which is equal to posts table row...properties = columns and assing new value to it
      $post->save();

      return redirect()->route('admin.index')->with('info', 'Post created, Title is: ' . $request->input('title'));// Here we return Redirect HTTP header object with specified url
      
    }

    //This is the method triggered when user (admin) submits admin.edit form
    public function postAdminUpdate(Request $request) {
      $this->validate($request, [ // Here we place our validation logic
        'title' => 'required|min:5',
        'content' => 'required|min:10'
      ]);
      $post = Post::find($request->input('id')); // Here we use $request->input() method to retrieve users input id  from request - and we find eloquen model instance(row) which we want to update
      $post->title = $request->input('title'); // Here we overrides our title and content propeties of our eloquent model instance(row)
      $post->content = $request->input('content');
      $post->save();// Here we save it again in the database
      return redirect()->route('admin.index')->with('info', 'Post edited, new Title is: ' . $request->input('title'));
    }

    public function getAdminDelete($id) {
      $post = Post::find($id);
      $post->delete();
      return redirect()->route('admin.index')->with('info', 'Post deleted');
    }



}
