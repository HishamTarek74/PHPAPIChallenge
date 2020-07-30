<?php

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\User;
class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
               // Let's truncate our existing records to start from scratch.
               Post::truncate();

               $faker = \Faker\Factory::create();
               $user = User::pluck('id');
       
               // And now, let's create a few articles in our database:
               for ($i = 0; $i < 50; $i++) {
                   Post::create([
                       'title' => $faker->title,
                       'post_content' => 'Post Content',
                       'author' => 'Hisham',
                       'user_id' => 1
                   ]);
               }
    }
}
