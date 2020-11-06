<?php

namespace App\Models;

use App\Traits\OwnerConfig;

class Debtor extends Model
{
    use OwnerConfig;

    protected $fillable = [
        'name', 'email', 'phones',
    ];

    protected $casts = [
        'phones' => 'array',
    ];
}
