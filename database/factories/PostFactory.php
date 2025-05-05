<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    const RAND_IMAGE_URL = 'https://picsum.photos/';

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        /**
         * Post tags
         *
         * @var array<string>
         */
        $tags = ['History', 'Forest', 'Water', 'Castle', 'Sea'];

        return [
            'title' => rtrim(fake()->sentence(3), '.'),
            'user_id' => User::factory(),
            'slug' => fake()->slug(),
            'image' => self::RAND_IMAGE_URL.fake()->numberBetween(200, 800).'/'.fake()->numberBetween(200, 800),
            'tags' => implode(', ', fake()->randomElements($tags, 3)),
            'price' => fake()->randomFloat(2, 0, 50),
        ];
    }
}
