<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        /**
         * Post activities type
         *
         * @var array<string>
         */
        $type = ['Updated', 'Liked', 'Commented'];


        return [
            'post_id' => Post::all()->random()->id,
            'type' => fake()->randomElement($type)
        ];
    }
}
