<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostService
{

    // TODO:
    // [] - setAuthorNamesTo and setAuthorNameTo replace with one function
    public function setAuthorNamesTo(LengthAwarePaginator $posts): void
    {
        $posts->map(function ($post) {
            $post->author = $post->user->name;
        });
    }

    public function setAuthorNameTo(Post $post): void
    {
        $post->author = $post->user->name;
    }


    /**
     * Returns path of stored image
     *
     * @param UploadedFile $image
     * @return string
     */
    public function returnPathOf(UploadedFile $image): string
    {
        $imageName = Storage::disk('media')->put('images', $image);
        $imagePath = parse_url(Storage::disk('media')->url($imageName))['path'];

        return $imagePath;
    }

    /**
     * Store post in database
     *
     * @param array<string, UploadedFile|string> $postData
     * @param integer|string $userId
     * @param string $imagePath
     * @return void
     */
    public function store(array $postData, int|string $userId, string $imagePath): void
    {
        $postData['user_id'] = $userId;
        $postData['image'] = $imagePath;

        Post::create($postData);
    }
}
