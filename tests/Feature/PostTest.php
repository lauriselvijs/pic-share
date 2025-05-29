<?php

use App\Contracts\CanManipulateFiles;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use function PHPUnit\Framework\assertNotNull;


uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(User::factory()->createOne());
});

test('authorized user stores post', function () {
    $fileManipulator = app(CanManipulateFiles::class);
    $storage = $fileManipulator->getStorageName();

    Storage::fake($storage);

    $postImage = UploadedFile::fake()->image('post.jpg')->size(config('constants.max_file_size'));

    $response = $this->post(
        route('posts.store'),
        [
            'title' => 'Post',
            'image' => $postImage,
            'tags' => 'post, test',
            'price' => 23.45,
        ]
    );

    Storage::disk($storage)->assertExists($postImage->hashName());

    $response->assertRedirect(route('posts.index'));

    // Check if post exists in DB
    $post = Post::where('title', 'Post')->first();

    assertNotNull($post);

    // Check if user can see its post on post page
    $response = $this->get(route('posts.index'));

    $response->assertOk();
    $response->assertSeeText($post->title);
});