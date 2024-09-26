<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tagsCategory = collect(['Programming', 'Lifestyle', 'Travel', 'Cooking', 'Entertainment', 'Sports', 'Health', 'Education', 'Families', 'Relationships']);
       
        // $tagsCategory->each(function ($tagName) {
        //     $tag = new Tag();
        //     $tag->name = $tagName;
        //     $tag->slug = Str::slug($tagName, '-');
        // });
        // $category = $tagsCategory->unique()->random();

        // return [
        //     'name' => $category,
        //     'slug' => Str::slug($category, '-')
        // ];
        return [
        // 
        ];
    }
}
