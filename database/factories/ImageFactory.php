<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{



    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        /**
         * Image tags
         *
         * @var array<string>
         */
        $tags = ["History", "Forest", "Water", "Castle", "Sea"];

        return [
            "title" =>  rtrim(fake()->sentence(3), "."),
            "author" => fake()->name(),
            "image" => fake()->imageUrl(),
            "tags" => implode(", ", fake()->randomElements($tags, 3))
        ];
    }
}
