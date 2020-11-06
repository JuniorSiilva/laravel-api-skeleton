<?php

namespace App\Repositories;

use App\Models\Debt;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\DebtRepositoryContract;

class DebtRepository extends Repository implements DebtRepositoryContract
{
    protected $model = Debt::class;

    public function getAll(bool $paginate = false, int $take = 15, string $search = '', string $from = '', string $to = '', array $debtors = [])
    {
        $query = $this->getQuery();

        $query->where('description', 'ILIKE', "%$search%");

        $query->whereFromToDate($from, $to, 'buy_date');

        $query->when($debtors, function (Builder $query) use ($debtors) {
            $query->whereHas('debtors', function (Builder $query) use ($debtors) {
                $query->whereIn('id', $debtors);
            });
        });

        $query->with(['debtors']);

        $query->withCount([
            'payments AS payments_completed' => function ($query) {
                $query->payed();
            },
        ]);

        $query->orderBy('buy_date', 'ASC');

        if ($paginate) {
            return $query->paginate($take);
        }

        return $query->get();
    }
}
