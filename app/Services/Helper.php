<?php

namespace App\Services;

use Illuminate\Support\Str;

class Helper
{
    /**
     * Generates unique username for given email
     */
    public static function generateUsernameFrom(string $email): string
    {
        return Str::of($email)->before("@")->ascii()->append('-')->append(Str::uuid())->lower();
    }
}
