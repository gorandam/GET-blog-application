<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Home page routes
Route::get('/', ['uses' => 'PostController@getIndex', 'as' => 'blog.index']); // Here we use syntax to nickname routes

Route::get('post/{id}', [
  'uses' => 'PostController@getPost',
  'as' => 'blog.post'
]);
// This is route to our likes method to show us likes on every single post page...
Route::get('post/{id}/like', [
  'uses' => 'PostController@getLikePost',// This will call controller action wich will create new like and save it with many to one relaion to post in the database
  'as' => 'blog.post.like'
]);

//Route when we click about - it stays the same and it is static
Route::get('about', function () {
  return view('other.about');
})->name('other.about');

//Admin page  routes
Route::group(['prefix' => 'admin'], function () {

  Route::get('', [
    'uses' => 'PostController@getAdminIndex',
    'as' => 'admin.index'
  ]);

  Route::get('create', [
    'uses' => 'PostController@getAdminCreate',
    'as' => 'admin.create'
  ]);

  Route::post('create', [
    'uses' => 'PostController@postAdminCreate',
    'as' => 'admin.create'
  ]);

  Route::get('edit/{id}', [
    'uses' => 'PostController@getAdminEdit',
    'as' => 'admin.edit'
  ]);

  Route::post('edit', [
    'uses' => 'PostController@postAdminUpdate',
    'as' => 'admin.update'
  ]);

  Route::get('delete/{id}', [
    'uses' => 'PostController@getAdminDelete',
    'as' => 'admin.delete'
  ]);

});
