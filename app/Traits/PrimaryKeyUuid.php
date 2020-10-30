<?php

namespace App\Traits;

use Illuminate\Support\Str;
use App\Contracts\PrimaryKeyUuid as PrimaryKeyUuidContract;

trait PrimaryKeyUuid
{
    public static function bootPrimaryKeyUuid()
    {
        static::creating(function ($model) {
            if ($model instanceof PrimaryKeyUuidContract && ! is_null($model->getKeyName()) && $model->getKeyType() === 'string') {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
