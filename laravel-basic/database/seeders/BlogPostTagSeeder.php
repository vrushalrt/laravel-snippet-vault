<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogPostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tagCount = Tag::all()->count();

        if( $tagCount > 0 ) {
            $howMinTag = (int) $this->command->ask('How many MIN tags should be created per post?', 1);
            $howMaxTag = min((int) $this->command->ask('How many MAX tags should be created per post?', $tagCount), $tagCount);
            
            BlogPost::all()->each( function(BlogPost $post) use($howMinTag, $howMaxTag) {
                $take = random_int($howMinTag, $howMaxTag);
                $tags = Tag::inRandomOrder()->take($take)->get()->pluck('id');
                $post->tags()->sync($tags); 
            });

            // $howManyTag = random_int($howMinTag, $howMaxTag);



        }
    }
}
