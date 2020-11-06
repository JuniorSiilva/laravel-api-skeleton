<?php

namespace App\Models;

use App\Traits\OwnerConfig;

class Attachment extends Model
{
    use OwnerConfig;

    protected $fillable = [
        'uniqid',
        'name',
        'type',
        'url',
        'description',
    ];

    public function attachmentable()
    {
        return $this->morphTo();
    }
}
