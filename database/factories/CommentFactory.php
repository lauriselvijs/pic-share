<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        /**
         *  @var string
         */
        $commentable = $this->faker->randomElement([
            Post::class,
            Video::class,
        ]);

        return [
            'commentable_type' => $commentable,
            'body' =>  fake()->text(),
        ];
    }
}
