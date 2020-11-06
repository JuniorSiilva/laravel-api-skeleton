<?php

namespace App\Models;

use App\Traits\OwnerConfig;
use App\Traits\EloquentHelpers;
use App\Models\Contracts\Attachmentable;

class Debt extends Model implements Attachmentable
{
    use OwnerConfig, EloquentHelpers;

    protected $fillable = [
        'description',
        'price',
        'buy_date',
        'payment_start_date',
        'installments',
        // 'status',
    ];

    protected $casts = [
        'price' => 'double',
        'payment_start_date' => 'date',
        'buy_date' => 'date',
    ];

    public function getInstallments()
    {
        return $this->installments;
    }

    public function getStartDate()
    {
        return $this->payment_start_date;
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    public function debtors()
    {
        return $this->belongsToMany(Debtor::class, 'debt_has_debtors');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachmentable');
    }
}
