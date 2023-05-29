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
        $activityStatus = (Activity::factory()->count(3)->for($user));
        $post = Post::factory()->count(3)->has($activityStatus)->hasActivityStatuses(2);

        User::factory()
            ->count(10)
            ->has($post)
            ->hasVideos(1)
            ->hasComments(1)
            ->create();

        // Post::factory()->hasActivities(1);

        // Activity::factory()->has

        // Activity::factory(10)->create();
        // ActivityStatus::factory(10)->create();

        // Comment::factory(10)->create();

        // Admin::factory(3)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
