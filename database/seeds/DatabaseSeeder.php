<?php

use App\Category;
use App\Post;
use App\User;
use App\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class,50)->create();
        factory(Category::class,15)->create();
        factory(Post::class,50)->create();
        factory(Comment::class,100)->create();

    }
}
