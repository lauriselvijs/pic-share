<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Post;
use App\Models\Admin;
use App\Models\Video;
use App\Models\Activity;
use App\Models\AdminRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        Post::factory()->count(20)->hasComments(3)->create();
        Video::factory()->count(10)->hasComments(3)->create();

        Activity::factory()->count(3)->hasActivityStatuses(2)->create();

        $twoAdminRoles = AdminRole::factory()->count(2)->twoAdminRoles()->create();
        $threeAdminRoles = AdminRole::factory()->count(3)->threeAdminRoles()->create();

        Admin::factory()->count(1)->notify()->hasAttached($twoAdminRoles)->create();
        Admin::factory()->count(50)->hasAttached($threeAdminRoles)->create();
        Admin::factory()->count(50)->hasAttached($threeAdminRoles)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
