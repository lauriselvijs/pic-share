<?php

namespace App\Services;

use App\Contracts\CanManipulateFiles;
use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostService
{
    public function __construct(private CanManipulateFiles $fileManipulator)
    {
        $this->fileManipulator = $fileManipulator;
    }

    /**
     * Post table image path column name
     * 
     * @var string
     */
    private const IMAGE = 'image';

    // TODO:
    // [ ] - returnWithAuthorNames and returnWithAuthorName replace with one function
    /**
     * Includes author name in posts.
     */
    public function includeAuthorNamesInPosts(LengthAwarePaginator $posts): LengthAwarePaginator
    {
        $posts->map(function ($post) {
            $post->author = $post->user->name;
            // $post->image = $this->fileManipulator->generateTemporaryUrl($post->image);
        });

        return $posts;
    }

    /**
     * Includes author name in post.
     */
    public function includeAuthorNameInPost(Post $post): Post
    {
        $post->author = $post->user->name;

        return $post;
    }

    /**
     * Returns path of stored image.
     */
    public function saveAndReturnPathOfImage(UploadedFile $image): string
    {

        // $this->fileManipulator->storeFileAndReturnPath($image);

        $imageName = Storage::disk(config('constants.MEDIA_DISK'))->put('images', $image);
        $imagePath = parse_url(Storage::disk(config('constants.MEDIA_DISK'))->url($imageName))['path'];

        return $imagePath;
    }

    /**
     * Delete givin media file at a given path.
     */
    public function deleteMediaFile(string $path): void
    {
        $fileRelativePathInDisk = Helper::getFileRelativePathInDisk(config('constants.MEDIA_DISK'), $path);

        Storage::disk(config('constants.MEDIA_DISK'))->delete($fileRelativePathInDisk);
    }

    /**
     * Update existing image with new one and return new image path.
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
     */
    public function store(array $postData): void
    {
        $imagePath = $this->saveAndReturnPathOfImage($postData[self::IMAGE]);
        $postData[self::IMAGE] = $imagePath;

        Post::create($postData);
    }

    /**
     * Update post.
     */
    public function update(Post $post, array $postData)
    {
        if (isset($postData[self::IMAGE]) && $postData[self::IMAGE]) {
            $imagePath = $this->updatePathOfImage($postData[self::IMAGE], $post->image);
            $postData[self::IMAGE] = $imagePath;
        }

        $post->update($postData);
    }

    /**
     * Deletes given post.
     */
    public function delete(Post $post): void
    {
        $this->deleteMediaFile($post->image);

        $post->delete();
    }
}
