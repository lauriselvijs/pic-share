<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Helper
{
    /**
     * Returns path of file relative to disk
     *
     * @param string $disk disk name
     * @param string $path path of file that starts with disk name
     * @return string file relative path in disk
     */
    public static function getFileRelativePathInDisk(string $disk, string $path): string
    {
        $diskName = basename(Storage::disk($disk)->path(''));

        return str_replace('/' . $diskName . '/', '', $path);
    }

    /**
     * Generates unique username for given users name
     *
     * @param string $name name of user
     * @return string generated username
     */
    public static function generateUsernameFor(string $name): string
    {
        return Str::of($name)->before(' ')->append('_')->append(Str::uuid())->lower();
    }
}
