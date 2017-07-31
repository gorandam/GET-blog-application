<?php

use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $post = new \App\Post([
          'title' => 'Learning Laravel',
          'content' => 'This blog post will send us right on the track!'
        ]);
        $post->save();

        $post = new \App\Post([
          'title' => 'Something Else',
          'content' => 'Some Other Content'
        ]);
        $post->save();

    }
}
