<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Contracts\CanGenerateProfilePic;

class PixelenCounterService implements CanGenerateProfilePic
{
    /**
     * Generates user profile picture using PixelenCounter service
     */
    public function generate(bool $colored = true): string
    {
        // TODO:
        // [ ] - Replace url with config or const 
        $response = Http::get('https://app.pixelencounter.com/api/v2/basic/svgmonsters', [
            'colored' => $colored ? "true" : "false"
        ]);

        return $response->body();
    }
}
