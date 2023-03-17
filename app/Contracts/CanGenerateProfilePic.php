<?php

namespace App\Contracts;

interface CanGenerateProfilePic
{

    /**
     * Generates user profile picture
     *
     */
    public function generate(bool $colored = true): string;
}
