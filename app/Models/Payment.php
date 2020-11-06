<?php

namespace App\Models;

use App\Traits\OwnerConfig;
use App\Enums\PaymentStatus;
use App\Traits\EloquentHelpers;
use Illuminate\Database\Eloquent\Builder;

class Payment extends Model
{
    use OwnerConfig, EloquentHelpers;

    protected $fillable = [
        'price',
        'installment',
        // 'status',
        'payment_date',
        // 'receipt_date',
    ];

    protected $casts = [
        'price' => 'double',
    ];

    public function isPaid()
    {
        return (bool) $this->receipt_date;
    }

    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    public function setReceiptDate(?string $date)
    {
        $this->receipt_date = $date;
    }

    public function debtor()
    {
        return $this->belongsTo(Debtor::class);
    }

    public function debt()
    {
        return $this->belongsTo(Debt::class);
    }

    public function scopePayed(Builder $query)
    {
        $query->where('status', PaymentStatus::PAGO);
    }
}
