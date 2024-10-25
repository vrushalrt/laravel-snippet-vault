<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\User;
use Database\Factories\BlogPostFactory;
use Database\Factories\CommentFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blogPosts = BlogPost::all();

        $user = User::all();

        CommentFactory::new()->count(100)->make()->each(function($comment) use ($blogPosts, $user) {
            $comment->commentable_id = $blogPosts->random()->id;
            $comment->commentable_type = BlogPost::class;
            $comment->user_id = $user->random()->id;
            $comment->save();
        });

        CommentFactory::new()->count(100)->make()->each(function($comment) use ($blogPosts, $user) {
            $comment->commentable_id = $user->random()->id;
            $comment->commentable_type = User::class;
            $comment->user_id = $user->random()->id;
            $comment->save();
        });

    }
}
