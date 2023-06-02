<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\models\Post;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = app(Faker::class);
        
        return [
            'user_id' => $faker->numberBetween(1,50),
            'place' => $faker->text($maxNbChars = 6),
            'star' => $faker->numberBetween(1,5),
            'title' => $faker->word,
            'body' => $faker->text($maxNbChars = 30),
            'prefecture_id' => $faker->numberBetween(1,47)
     
         
        ];
    }
}
