<?php

namespace App\Models;

use App\Traits\OwnerConfig;
use App\Enums\PaymentStatus;
use App\Traits\EloquentHelpers;
use Illuminate\Database\Eloquent\Builder;

class Payment extends Model
{
    use OwnerConfig, EloquentHelpers;

    private $payEvent;

    protected $fillable = [
        'price',
        'installment',
        // 'status',
        'payment_date',
        // 'receipt_date',
    ];

    protected $casts = [
        'price' => 'double',
        'payment_date' => 'date',
    ];

    protected $observables = [
        'pay',
        'unpay',
    ];

    public function getDescriptionForEvent(string $eventName): string
    {
        return (bool) $this->payEvent ? $this->payEvent : $eventName;
    }

    public function isPaid()
    {
        return (bool) $this->receipt_date;
    }

    public function getInstallment()
    {
        return $this->installment;
    }

    public function getDebt()
    {
        return $this->debt;
    }

    public function getPrice(bool $format = false)
    {
        if ($format) {
            return number_format($this->price, 2, ',', '.');
        }

        return $this->price;
    }

    public function pay()
    {
        $this->status = PaymentStatus::PAGO;
        $this->receipt_date = date('Y-m-d');
        $this->payEvent = 'pay';
        $this->save();

        $this->fireModelEvent($this->payEvent, false);
    }

    public function unpay()
    {
        $this->status = PaymentStatus::PENDENTE;
        $this->receipt_date = null;
        $this->payEvent = 'unpay';
        $this->save();

        $this->fireModelEvent($this->payEvent, false);
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
