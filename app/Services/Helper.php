<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Helper
{
    /**
     * Generates unique username for given users name
     */
    public static function generateUsernameFor(string $name): string
    {
        return Str::of($name)->replace(' ', '.')->ascii()->append('#')->append(Str::uuid())->lower();
    }
}
