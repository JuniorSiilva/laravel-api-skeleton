<?php

namespace App\Models;

use App\Traits\OwnerConfig;

class Tag extends Model
{
    use OwnerConfig;

    protected $fillable = [
        'name',
    ];
}
