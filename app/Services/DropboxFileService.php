<?php

namespace App\Services;

use App\Contracts\CanManipulateFiles;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * This class provides file manipulation functionality specifically for the Dropbox file storage service.
 */
class DropboxFileService implements CanManipulateFiles
{
    /**
     * Link expiration time is 4 hours (https://www.dropbox.com/developers/documentation/http/documentation#files-get_temporary_link)
     * 
     * @var int
     */
    protected final const URL_EXPIRATION_TIME = 60 * 60 * 4;


    public function store(UploadedFile $file): string
    {
        $path = Storage::disk(self::STORAGE_DISK_NAME)->putFile('/', $file);

        return $path;
    }

    public function generateTemporaryUrl(string $path): string
    {
        try {
            return cache()->remember(($path), self::URL_EXPIRATION_TIME, function () use ($path) {
                return Storage::disk(self::STORAGE_DISK_NAME)->url(config('filesystems.disks.dropbox-files.root') . '/' . $path);
            });
        } catch (\Throwable $th) {
            return $path;
        }
    }

    public function delete(string $path): void
    {
        Storage::disk(self::STORAGE_DISK_NAME)->delete($path);
    }

    public function update(UploadedFile $file, string $oldPath): string
    {
        $this->delete($oldPath);
        $path = $this->store($file);

        return $path;
    }
}
