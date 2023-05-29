<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        /**
         * VIdeo tags
         *
         * @var array<string>
         */
        $tags = ['History', 'Forest', 'Water', 'Castle', 'Sea'];

        return [
            'title' =>  rtrim(fake()->sentence(3), '.'),
            'thumbnail' =>  fake()->imageUrl(),
            'path' => fake()->url(),
            'tags' => implode(', ', fake()->randomElements($tags, 3))
        ];
    }
}
