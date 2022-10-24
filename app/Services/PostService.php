<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostService
{
    // TODO:
    // [ ] - returnWithAuthorNames and returnWithAuthorName replace with one function
    /**
     * Includes author name in posts.
     *
     * @param LengthAwarePaginator $posts
     * @return LengthAwarePaginator
     */
    public function includeAuthorNamesInPosts(LengthAwarePaginator $posts): LengthAwarePaginator
    {
        $posts->map(function ($post) {
            $post->author = $post->user->name;
        });

        return $posts;
    }

    /**
     * Includes author name in post.
     *
     * @param Post $post
     * @return Post
     */
    public function includeAuthorNameInPost(Post $post): Post
    {
        $post->author = $post->user->name;

        return $post;
    }


    /**
     * Returns path of stored image.
     *
     * @param UploadedFile $image
     * @return string
     */
    public function saveAndReturnPathOfImage(UploadedFile $image): string
    {
        $imageName = Storage::disk(config('constants.MEDIA_DISK'))->put('images', $image);
        $imagePath = parse_url(Storage::disk(config('constants.MEDIA_DISK'))->url($imageName))['path'];

        return $imagePath;
    }

    /**
     * Delete givin media file at a given path.
     *
     * @param string $path File path to delete
     * @return void
     */
    public function deleteMediaFile(string $path): void
    {

        $fileRelativePathInDisk = Helper::getFileRelativePathInDisk(config('constants.MEDIA_DISK'), $path);

        Storage::disk(config('constants.MEDIA_DISK'))->delete($fileRelativePathInDisk);
    }

    /**
     * Update existing image with new one and return new image path.
     *
     * @param UploadedFile|null $newImage
     * @param string $oldImagePath
     * @return string|bool
     */
    public function updatePathOfImage(UploadedFile $newImage, string $oldImagePath): string
    {
        $this->deleteMediaFile($oldImagePath);
        return $this->saveAndReturnPathOfImage($newImage);
    }

    /**
     * Store post in database.
     *
     * @param array<string, int|string|UploadedFile> $postData
     * @return void
     */
    public function store(array $postData): void
    {
        $imagePath = $this->saveAndReturnPathOfImage($postData[config('constants.POST_IMG')]);
        $postData[config('constants.POST_IMG')] = $imagePath;

        Post::create($postData);
    }

    /**
     * Update post.
     *
     * @param Post $post
     * @param array $postData
     * @return void
     */
    public function update(Post $post, array $postData)
    {
        if ($postData[config('constants.POST_IMG')]) {
            $imagePath = $this->updatePathOfImage($postData[config('constants.POST_IMG')], $post->image);
            $postData[config('constants.POST_IMG')] = $imagePath;
        }

        $post->update($postData);
    }

    /**
     * Deletes given post.
     *
     * @param Post $post
     * @return void
     */
    public function delete(Post $post)
    {
        $this->deleteMediaFile($post->image);

        $post->delete();
    }
}
