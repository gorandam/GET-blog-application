<?php

use Illuminate\Database\Seeder;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tag = new \App\Tag();// Here we create our new eloquent model and store it in the database
        $tag->name = 'Tutorial';
        $tag->save();

        $tag = new \App\Tag();
        $tag->name = 'Industry News';
        $tag->save();
    }
}
