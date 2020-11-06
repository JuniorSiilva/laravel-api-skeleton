<?php

namespace App\Repositories;

use App\Models\Payment;
use App\Enums\PaymentStatus;
use App\Repositories\Contracts\PaymentRepositoryContract;

class PaymentRepository extends Repository implements PaymentRepositoryContract
{
    protected $model = Payment::class;

    public function getAll(bool $paginate = false, int $take = 15, string $search = '', string $from = '', string $to = '', int $debtId = null)
    {
        $query = $this->getQuery();

        $query->orderByRaw('status = \'' . PaymentStatus::PENDENTE . '\' DESC');

        $query->orderBy('payment_date', 'ASC');

        if ($debtId) {
            $query->where('debt_id', $debtId);
        }

        if ($paginate) {
            return $query->paginate($take);
        }

        return $query->get();
    }
}
