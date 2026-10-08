<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          Post::all()->each(function (Post $post) {
            Comment::factory()
                ->count(2)
                ->for($post)
                ->state(fn () => [
                    'user_id' => User::inRandomOrder()->value('id'),
                ])
                ->create();

            Comment::factory()
                ->asGuest()
                ->for($post)
                ->create();
        });
    }
}
