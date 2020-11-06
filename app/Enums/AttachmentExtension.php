<?php

namespace App\Enums;

class AttachmentExtension extends Enum
{
    public const JPG = 'jpg';

    public const JPEG = 'jpeg';

    public const PNG = 'png';

    public const MP4 = 'mp4';

    public const AVI = 'avi';

    public static function imageTypes() : array
    {
        return [self::JPG, self::JPEG, self::PNG];
    }

    public static function videoTypes() : array
    {
        return [self::MP4, self::AVI];
    }

    public static function availableMimeTypes() : string
    {
        return implode(',', self::getValues());
    }
}
