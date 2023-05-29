<?php

namespace Database\Factories;

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
            'type' => fake()->randomElement($type)
        ];
    }
}
