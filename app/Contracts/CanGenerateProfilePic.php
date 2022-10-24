<?php

namespace App\Contracts;

interface CanGenerateProfilePic
{

    /**
     * Generates user profile picture
     *
     * @param boolean $colored
     * @return string
     */
    public function generate(bool $colored = true): string;
}
