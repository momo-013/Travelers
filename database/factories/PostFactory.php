<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'place' => fake()->text($maxNbChars = 6),
            'star' => 4,
            'title' => fake()->word,
            'body' => fake()->text($maxNbChars = 10),
            'prefecture_id' => 1,
     
         
        ];
    }
}
