<?php

namespace App\Repositories;

use App\Models\Payment;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\PaymentRepositoryContract;

class PaymentRepository extends Repository implements PaymentRepositoryContract
{
    protected $model = Payment::class;

    public function getAll(bool $paginate = false, int $take = 15, string $search = '', string $from = '', string $to = '', ?int $debtId = null, array $debtors = [], array $status = [], array $tags = [])
    {
        $query = $this->getQuery();

        $query->orderByRaw('status = \'' . PaymentStatus::PENDENTE . '\' DESC');

        $query->orderBy('payment_date', 'ASC');

        $query->whereFromToDate($from, $to, 'payment_date', 'DATE', 'CURRENT_MONTH');

        if (! empty($debtors)) {
            $query->whereIn('debtor_id', $debtors);
        }

        if (! empty($status)) {
            $query->whereIn('status', $status);
        }

        if ($tags) {
            $query->whereHas('debtors.tags', function (Builder $query) use ($tags) {
                $query->whereIn('id', $tags);
            });
        }

        if ($debtId) {
            $query->where('debt_id', $debtId);
        }

        if ($paginate) {
            return $query->paginate($take);
        }

        return $query->get();
    }

    public function getFromYearMonthAndDebtor(int $debtorId, string $year, string $month)
    {
        $query = $this->getQuery();

        $query->orderByRaw('status = \'' . PaymentStatus::PENDENTE . '\' DESC');

        $query->orderBy('payment_date', 'ASC');

        $query->whereMonth('payment_date', $month)
            ->whereYear('payment_date', $year)
            ->where('debtor_id', $debtorId);

        $query->with('debt');

        return $query->get();
    }
}
