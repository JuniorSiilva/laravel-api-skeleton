<?php

namespace App\Models;

use App\Traits\OwnerConfig;
use App\Models\Contracts\Attachmentable;

class Debt extends Model implements Attachmentable
{
    use OwnerConfig;

    protected $fillable = [

    ];

    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    public function debtors()
    {
        return $this->belongsToMany(Debtor::class, 'debt_has_debtors');
    }
}
