<?php

namespace Database\Factories;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ActivityStatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        /**
         * Activity status type
         *
         * @var array<string>
         */
        $type = ['Pending', 'Approved', 'Rejected'];


        return [
            'activity_id' => Activity::all()->random()->id,
            'type' => fake()->randomElement($type)
        ];
    }
}
