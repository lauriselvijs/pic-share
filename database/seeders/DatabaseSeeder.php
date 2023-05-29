<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Post;
use App\Models\Admin;
use App\Models\Video;
use App\Models\Comment;
use App\Models\Activity;
use App\Models\ActivityStatus;
use App\Models\User;
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

        $user = User::factory()->create();
        $activity = Activity::factory()->count(3)->for($user)->hasActivityStatuses(2);
        $post = Post::factory()->count(3)->has($activity);

        User::factory()
            ->count(10)
            ->has($post)
            ->hasVideos(1)
            ->hasComments(1)
            ->create();

        // Admin::factory(3)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
