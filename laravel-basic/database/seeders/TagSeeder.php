<?php

namespace Database\Seeders;

use App\Models\Tag;
use Database\Factories\TagFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tagsCategory = collect(['Programming', 'Lifestyle', 'Travel', 'Cooking', 'Entertainment', 'Sports', 'Health', 'Education', 'Families', 'Relationships']);

        $tagsCategory->each(function($tagName) {
            $tag = new Tag();
            $tag->name = $tagName;
            $tag->slug = Str::slug($tagName, '-');
            $tag->save();
        });
    }
}
