<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class Helper
{

    /**
     * Returns path of file relative to disk
     *
     * @param string $disk disk name
     * @param string $path path of file that starts with disk name
     * @return string
     */
    public static function getFileRelativePathInDisk(string $disk, string $path): string
    {
        $diskName = basename(Storage::disk($disk)->path(''));

        return str_replace('/' . $diskName . '/', '', $path);
    }
}
