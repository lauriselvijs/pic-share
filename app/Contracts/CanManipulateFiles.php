<?php

namespace App\Contracts;

use Illuminate\Http\UploadedFile;

/**
 * This interface defines the methods that a class must implement to be able to manipulate files.
 */
interface CanManipulateFiles
{
    /**
     * Stores an uploaded file.
     * 
     * @param UploadedFile $file The file to be stored.
     * 
     * @return string The path of the stored file.
     */
    public function store(UploadedFile $file): string;

    /**
     * Generates a temporary URL for a stored file.
     * 
     * @param string $filePath The path of the file for which a temporary URL is being generated.
     * 
     * @return string The temporary URL of the specified file, if it cant return url returns file path given.
     */
    public function generateTemporaryUrl(string $filePath): string;

    /**
     * Deletes a stored file.
     * 
     * @param string $path The path of the file to be deleted.
     * 
     * @return void
     */
    public function delete(string $path): void;

    /**
     * Updates a stored file.
     * 
     * @param UploadedFile $newImage The updated file.
     * @param string $oldImagePath The path of the file to be updated.
     * 
     * @return string The path of the updated file.
     */
    public function update(UploadedFile $newImage, string $oldImagePath): string;
}
