<?php

namespace App\Http\Controllers;

use App\Like; // Here we import in namespace Like model
use App\Post;// We use it to import post model
use App\Tag;// Here we import in namespace Tag model
use Illuminate\Http\Request;


class PostController extends Controller
{
    // This is the method to fetch and display our retrieved data (posts) from database
    public function getIndex() {
      $posts = Post::orderBy('created_at', 'desc')->get();//Here we use our costrains to substitute all() fetch method
      return view('blog.index', ['posts' => $posts]);// here we retrun View response object and pased retrived data to the our view
    }

    // This is the method to display all our posts for the admin
    public function getAdminIndex() {
      $posts = Post::orderBy('title', 'asc')->get(); //Here we replace our fetch method with orderBy and get() with ascending alphabetical
      return view('admin.index', ['posts' => $posts]);// here we retrun View response object and pased retrived data to the our view
    }

    // This is the method to acess and display single post at home page
    public function getPost($id) {
      $post = Post::where('id', $id)->with('likes')->first();//Here we use our find fetch method to find single post with this $id and replace it with compex eloquent query using when() and firs()
      return view('blog.post', ['post' => $post]);// here we retrun View response object and pased retrived data to the our view
    }

    // This is the method to acess and display like of single post at home page
    public function getLikePost($id) {
      $post = Post::where('id', $id)->first();//Here we use our find fetch method to find single post with this $id and replace it with compex eloquent query using when() and first()
      $like = new Like();
      $post->likes()->save($like);
      //var_dump($post->likes());//  This will return instance of lluminate\Database\Eloquent\Relations\HasMany class that investigate if relationship  exists
      return redirect()->back(); // This will brings us back in the single post page.....
    }

     // Here are ADMIN methods
    // This is the method that allows admin to create new post
    public function getAdminCreate() {
      $tags = Tag::all();
      return view('admin.create', ['tags' => $tags]); // This returns admin create template to create posts by admin and we here pass view data
    }

    // This is the method that allows admin to edit one post
    public function getAdminEdit($id) {
      $post = Post::find($id);
      $tags = Tag::all();// This will retrun collection object of all tag instances
      return view('admin.edit', ['post' => $post, 'postId' => $id, 'tags' => $tags]);// here we retrun View response object and pased retrived data to the our view
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
      $post->tags()->attach($request->input('tags') === null ? [] : $request->input('tags')); //Here we create many to many relations ant tells laravel that with this post id in  post_id field  and save ids from all tags model instaces from array. in tag_id fields..

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
      //$post->tags()->detach();
      //$post->tags()->attach($request->input('tags') === null ? [] : $request->input('tags')); // We can do it this way but we have better way
      $post->tags()->sync($request->input('tags') === null ? [] : $request->input('tags'));// We still use $post-tags() method with ->sync() method....sync() tells Laravel to figure out which tags actually changed, and this will only detach the tags which are not use anymore, and attach the new ones, so this is more efficient.

      return redirect()->route('admin.index')->with('info', 'Post edited, new Title is: ' . $request->input('title'));
    }

    public function getAdminDelete($id) {
      $post = Post::find($id);//Select eloquent model
      $post->likes()->delete(); // Here we select all realted likes eloquet model instances and delete it...
      $post->tags()->detach();// Here we detache all tags - remove relations and delete all tags model instances...
      $post->delete();// delete it with oudr delete() eloquent method method
      return redirect()->route('admin.index')->with('info', 'Post deleted!!!');// We redirect it to the admin index
    }



}
