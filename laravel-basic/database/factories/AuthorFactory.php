<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }

    public function configure()
    {
        $this->afterCreating(
            function (Author $author) {
                $author->profile()->save(Profile::factory()->make());
            }
        );

        // $this->afterMaking(
        //     function (Author $author) {
        //         $author->profile()->save(Profile::factory()->make());
        //     }
        // );

        return $this;
    }
}
