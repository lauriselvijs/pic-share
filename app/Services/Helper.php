<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Helper
{
    /**
     * Returns path of file in disk
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
        return Str::of($name)->replace(' ', '.')->ascii()->append('#')->append(Str::uuid())->lower();
    }
}
