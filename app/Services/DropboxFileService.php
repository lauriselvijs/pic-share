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
    private const URL_EXPIRATION_TIME = 60 * 60 * 4;

    /**
     * The name of the storage disk that will be used.
     * 
     * @var string
     */
    private string $storage = 'dropbox-files';


    public function store(UploadedFile $file): string
    {
        $path = Storage::disk($this->getStorageName())->putFile('/', $file);

        return $path;
    }

    public function generateTemporaryUrl(string $path): string
    {
        try {
            return cache()->remember(($path), self::URL_EXPIRATION_TIME, function () use ($path) {
                return Storage::disk($this->getStorageName())->url(config('filesystems.disks.dropbox-files.root') . '/' . $path);
            });
        } catch (\Throwable $th) {
            return $path;
        }
    }

    public function delete(string $path): void
    {
        Storage::disk($this->getStorageName())->delete($path);
    }

    public function update(UploadedFile $file, string $oldPath): string
    {
        $this->delete($oldPath);
        $path = $this->store($file);

        return $path;
    }

    public function getStorageName(): string
    {
        return $this->storage;
    }
}
