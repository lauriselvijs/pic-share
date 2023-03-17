<?php

namespace App\Contracts;

use Illuminate\Http\UploadedFile;

interface CanManipulateFiles
{
    public function saveAndReturnPathOfFile(UploadedFile $file): string;
    // public function deleteFile(UploadedFile $image): void;
    // public function updatePathOfImage(UploadedFile $newImage, string $oldImagePath): string;
}
