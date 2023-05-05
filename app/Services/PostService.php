<?php

namespace App\Services;

use App\Contracts\CanManipulateFiles;
use App\Models\Post;
use Illuminate\Http\UploadedFile;
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
    private const IMAGE_COLUMN_NAME = 'image';

    /**
     * Includes author names and generates temporary url for posted images in post (all posts).
     */
    public function includeAuthorNamesAndGenImgUrlFor(LengthAwarePaginator $posts): LengthAwarePaginator
    {
        $posts->map(function ($post) {
            $post->author = $post->user->name;
            $post->image = $this->generateTempUrlForImg($post->image);;
        });

        return $posts;
    }

    /**
     * Includes author name and generates temporary url for posted image in post (single post).
     */
    public function includeAuthorNameAndGenImgUrlFor(Post $post): Post
    {
        $post->author = $post->user->name;
        $post->image = $this->generateTempUrlForImg($post->image);

        return $post;
    }

    public function generateTempUrlForImg(string $imagePath): string
    {
        return $this->fileManipulator->generateTemporaryUrl($imagePath);
    }

    /**
     * Returns path of stored image.
     */
    public function saveAndReturnPathOfImage(UploadedFile $image): string
    {
        $imagePath = $this->fileManipulator->store($image);

        return $imagePath;
    }

    /**
     * Delete givin media file at a given path.
     */
    public function deleteMediaFile(string $path): void
    {
        $this->fileManipulator->delete($path);
    }

    /**
     * Update existing image with new one and return new image path.
     */
    public function updatePathOfImage(UploadedFile $newImage, string $oldImagePath): string
    {
        $pathOfNewImage = $this->fileManipulator->update($newImage, $oldImagePath);

        return $pathOfNewImage;
    }

    /**
     * Store post in database.
     *
     * @param array<string, int|string|UploadedFile> $postData
     */
    public function store(array $postData): void
    {
        $imagePath = $this->saveAndReturnPathOfImage($postData[self::IMAGE_COLUMN_NAME]);
        $postData[self::IMAGE_COLUMN_NAME] = $imagePath;

        Post::create($postData);
    }

    /**
     * Update post.
     */
    public function update(Post $post, array $postData)
    {
        if (isset($postData[self::IMAGE_COLUMN_NAME]) && $postData[self::IMAGE_COLUMN_NAME]) {
            $imagePath = $this->updatePathOfImage($postData[self::IMAGE_COLUMN_NAME], $post->image);
            $postData[self::IMAGE_COLUMN_NAME] = $imagePath;
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
