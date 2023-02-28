<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Helper
{
    /**
     * Returns path of file relative to disk
     */
    public static function getFileRelativePathInDisk(string $disk, string $path): string
    {
        $diskName = basename(Storage::disk($disk)->path(''));

        return str_replace('/' . $diskName . '/', '', $path);
    }

    /**
     * Generates unique username for given users name
     */
    public static function generateUsernameFor(string $name): string
    {
        return Str::of($name)->before(' ')->append('_')->append(Str::uuid())->lower();
    }
}
