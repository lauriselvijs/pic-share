<?php

namespace App\Contracts;

use Illuminate\Http\UploadedFile;

interface CanManipulateFiles
{
    public function storeFileAndReturnPath(UploadedFile $file): string;
    public function getTemporaryUrlForFile(string $filePath, int $secondsActive): string;
    public function deleteFile(string $path): void;
    public function storeFileAndUpdatePath(UploadedFile $newImage, string $oldImagePath): string;
}
