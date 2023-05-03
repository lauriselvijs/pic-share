<?php

namespace App\Services;

use App\Contracts\CanManipulateFiles;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

// REVIEW: check if everything works before implementing
class DropboxFileService implements CanManipulateFiles
{
    /**
     * Name of disk that will be used
     * 
     * @var string
     */
    protected final const STORAGE_DISK_NAME = 'dropbox-files';


    public function store(UploadedFile $file): string
    {
        // $fileName = Storage::disk('dropbox-files')->putFile('/', $file);
        // $filePath = Storage::disk('dropbox-files')->path($fileName);

        $path = Storage::disk(self::STORAGE_DISK_NAME)->putFile('/', $file);

        return $path;
    }

    public function generateTemporaryUrl(string $path, ?int $secondsActive = self::TEMPORARY_URL_ACTIVE_DEFAULT_TIME): string
    {
        $url = Storage::disk(self::STORAGE_DISK_NAME)->temporaryUrl(
            $path,
            now()->addSeconds($secondsActive)
        );

        return $url;
    }

    public function delete(string $path): void
    {
        Storage::disk(self::STORAGE_DISK_NAME)->delete(Storage::disk(self::STORAGE_DISK_NAME)->path($path));
    }

    public function update(UploadedFile $file, string $oldPath): string
    {
        $this->delete($oldPath);
        $path = $this->saveFileAndReturnPath($file);

        return $path;
    }
}
