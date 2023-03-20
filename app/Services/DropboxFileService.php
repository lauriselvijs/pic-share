<?php

namespace App\Services;

use App\Contracts\CanManipulateFiles;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

// REVIEW: check if everything works before implementing
class DropboxFileService implements CanManipulateFiles
{

    /**
     * How long keep link active
     * 
     * @var int
     */
    protected final const TEMPORARY_URL_ACTIVE_DEFAULT_TIME = 60 * 5;

    public function storeFileAndReturnPath(UploadedFile $file): string
    {
        $fileName = Storage::disk('dropbox-files')->putFile('/', $file);
        $filePath = Storage::disk('dropbox-files')->path($fileName);

        return $filePath;
    }

    public function getTemporaryUrlForFile(string $filePath, int $secondsActive = self::TEMPORARY_URL_ACTIVE_DEFAULT_TIME): string
    {
        $url = Storage::disk('dropbox-files')->temporaryUrl(
            $filePath,
            now()->seconds($secondsActive)
        );

        return $url;
    }

    public function deleteFile(string $path): void
    {
        $fileRelativePathInDisk = Storage::disk('dropbox-files')->path($path);

        Storage::disk('dropbox-files')->delete($fileRelativePathInDisk);
    }

    public function storeFileAndUpdatePath(UploadedFile $newImage, string $oldImagePath): string
    {
        $this->deleteFile($oldImagePath);
        $filePath = $this->saveFileAndReturnPath($newImage);

        return $filePath;
    }
}
