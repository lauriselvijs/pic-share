<?php

namespace Database\Factories;

use App\Models\User;
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
        /**
         * Post tags
         *
         * @var array<string>
         */
        $tags = ["History", "Forest", "Water", "Castle", "Sea"];

        /**
         * User ids
         *
         * @var array<int>
         */
        $user_id = User::pluck("id")->toArray();

        return [
            "title" =>  rtrim(fake()->sentence(3), "."),
            "user_id" =>  fake()->randomElement($user_id),
            "image" => fake()->imageUrl(),
            "tags" => implode(", ", fake()->randomElements($tags, 3))
        ];
    }
}
