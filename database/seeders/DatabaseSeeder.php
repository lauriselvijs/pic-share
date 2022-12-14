<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Post;
use App\Models\Admin;
use App\Models\Video;
use App\Models\Comment;
use App\Models\Activity;
use App\Models\ActivityStatus;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();

        Post::factory(10)->create();
        Video::factory(10)->create();

        Activity::factory(10)->create();
        ActivityStatus::factory(10)->create();

        Comment::factory(10)->create();

        Admin::factory(3)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
