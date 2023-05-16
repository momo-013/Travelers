<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

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
            'user_id' => fake()->numberBetween(1,50),
            'place' => fake()->text($maxNbChars = 6),
            'star' => fake()->numberBetween(1,5),
            'title' => fake()->word,
            'body' => fake()->text($maxNbChars = 30),
            'prefecture_id' => fake()->numberBetween(1,47)
     
         
        ];
    }
}
