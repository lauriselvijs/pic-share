<?php

namespace Tests\Feature;

use App\Models\Post;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function PHPUnit\Framework\assertNotNull;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->createOne());
    }


    /**
     * Check if user can store posts
     */
    public function test_authorized_user_stores_post(): void
    {
        Storage::fake(config('constants.MEDIA_DISK'));

        $postImage = UploadedFile::fake()->image('post.jpg');

        $response = $this->post(
            route('posts.store'),
            [
                'title' => 'Post',
                'image' => $postImage,
                'tags' => 'post, test',
                'price' => 23.45
            ]
        );

        Storage::disk(config('constants.MEDIA_DISK'))->assertExists('images/' . $postImage->hashName());

        $response->assertRedirect(route('posts.index'));



        // Check if post exists in DB
        $post = Post::where('title', 'Post')->first();

        assertNotNull($post);

        // Check if user can see its post on post page
        $response = $this->get(route('posts.index'));

        $response->assertOk();
        $response->assertSeeText($post->title);
    }
}
