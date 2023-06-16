<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdminRole>
 */
class AdminRoleFactory extends Factory
{

    public function twoAdminRoles(): Factory
    {
        return $this->state(
            new Sequence(
                ['role' => 'Backend Engineer'],
                ['role' => 'Tester'],
            )
        );
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'role' => fake()->unique()->word()
        ];
    }
}
