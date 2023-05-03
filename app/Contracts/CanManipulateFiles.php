<?php

namespace App\Contracts;

use Illuminate\Http\UploadedFile;

interface CanManipulateFiles
{
    /**
     * How long keep link active
     * 
     * @var int
     */
    public const TEMPORARY_URL_ACTIVE_DEFAULT_TIME = 60 * 5;

    public function store(UploadedFile $file): string;
    public function generateTemporaryUrl(string $filePath, ?int $secondsActive = self::TEMPORARY_URL_ACTIVE_DEFAULT_TIME): string;
    public function delete(string $path): void;
    public function update(UploadedFile $newImage, string $oldImagePath): string;
}
