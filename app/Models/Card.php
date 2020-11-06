<?php

namespace App\Models;

use App\Traits\OwnerConfig;

class Card extends Model
{
    use OwnerConfig;

    protected $fillable = [
        'brand', 'digits',
    ];
}
