<?php

namespace App\Services\Contracts;

use Imagick;
use Illuminate\Http\UploadedFile;
use App\Models\Contracts\Attachmentable;

interface AttachmentServiceContract
{
    public function create(Attachmentable $model, UploadedFile $file, string $description = '') : int;

    public function createMany(Attachmentable $model, array $attachments);

    public function getFileContent(UploadedFile $file, bool $compress = true, int $quality = 80);

    public function compressImage(UploadedFile $file, int $quality, int $compressionType) : Imagick;

    public function remove(int $id) : int;
}
