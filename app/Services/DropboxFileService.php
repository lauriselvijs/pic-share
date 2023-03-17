<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Contracts\CanManipulateFiles;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DropboxFileService implements CanManipulateFiles
{
    public function saveAndReturnPathOfFile(UploadedFile $file): string
    {
        $fileName = Storage::disk('dropbox-files')->put("/", $file);
        // $filePath = Storage::disk('dropbox-files')->path($folder . "/" . $fileName);
        $filePath = Storage::disk('dropbox-files')->path($fileName);

        return $filePath;
    }

    // public function deleteMediaFile(string $inFolder = "."): void
    // {
    //     $fileRelativePathInDisk = Storage::disk(config('filesystems.disks.dropbox-files'))->path($inFolder);

    //     Storage::disk(config('constants.MEDIA_DISK'))->delete($fileRelativePathInDisk);
    // }

    // public function updatePathOfImage(UploadedFile $newImage, string $oldImagePath): string
    // {
    //     $this->deleteMediaFile($oldImagePath);
    //     return $this->saveAndReturnPathOfImage($newImage);
    // }
}
