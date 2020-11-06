<?php

namespace App\Services;

use DB;
use Imagick;
use Storage;
use App\Models\Attachment;
use Illuminate\Support\Str;
use App\Enums\AttachmentType;
use Illuminate\Http\UploadedFile;
use App\Enums\AttachmentExtension;
use App\Models\Contracts\Attachmentable;
use App\Services\Contracts\AttachmentServiceContract;

class AttachmentService extends Service implements AttachmentServiceContract
{
    public function create(Attachmentable $model, UploadedFile $file, string $description = '') : int
    {
        $attachment = new Attachment;

        $uniqId = Str::uuid();

        $fileType = $this->getFileType($file);

        $fullNameFile = $uniqId . '.' . ($fileType === AttachmentType::IMAGE ? AttachmentExtension::JPEG : $file->getClientOriginalExtension());

        $attachment->fill([
            'uniqid' => $uniqId,
            'name' => $file->getClientOriginalName(),
            'type' => $fileType,
            'url' => $this->save($file, $fullNameFile),
            'descriptions' => $description,
        ]);

        $attachment->attachmentable()->associate($model);

        DB::transaction(function () use ($attachment) {
            $attachment->save();
        });

        return $attachment->getKey();
    }

    public function remove(int $id) : int
    {
        $attachment = $this->attachmentRepository->findById($id, false);

        $attachment->delete();

        return $attachment->getKey();
    }

    public function createMany(Attachmentable $model, array $attachments)
    {
        foreach ($attachments as $attachment) {
            if (! empty($attachment['file']) && $attachment['file'] instanceof UploadedFile) {
                $this->create($model, $attachment['file'], $attachment['descriptions'] ?? '');
            }
        }
    }

    public function getFileContent(UploadedFile $file, bool $compress = true, int $quality = 80)
    {
        if ($compress && $this->getFileType($file) === AttachmentType::IMAGE) {
            $img = $this->compressImage($file, $quality, Imagick::COMPRESSION_JPEG);

            return $img->getImageBlob();
        }

        return $file->get();
    }

    public function compressImage(UploadedFile $file, int $quality, int $compressionType) : Imagick
    {
        $img = new Imagick($file->getPathname());

        $img->setImageFormat(AttachmentExtension::JPEG);

        $img->setImageCompression($compressionType);

        $img->setImageCompressionQuality($quality);

        return $img;
    }

    protected function getFileType(UploadedFile $file) : string
    {
        if (in_array($file->getClientOriginalExtension(), AttachmentExtension::imageTypes())) {
            return AttachmentType::IMAGE;
        }

        return AttachmentType::VIDEO;
    }

    protected function save(UploadedFile $file, string $name, string $disk = 'public') : string
    {
        Storage::disk($disk)->put($name, $this->getFileContent($file));

        return Storage::disk($disk)->url($name);
    }
}
