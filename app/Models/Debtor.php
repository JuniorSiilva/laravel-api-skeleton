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

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
