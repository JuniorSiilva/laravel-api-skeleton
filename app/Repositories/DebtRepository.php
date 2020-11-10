<?php

namespace App\Repositories;

use App\Models\Debt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\DebtRepositoryContract;

class DebtRepository extends Repository implements DebtRepositoryContract
{
    protected $model = Debt::class;

    public function getAll(bool $paginate = false, int $take = 15, string $search = '', string $from = '', string $to = '', array $debtors = [], array $tags = [])
    {
        $query = $this->getQuery();

        $query->where('description', 'ILIKE', "%$search%");

        $query->whereFromToDate($from, $to, 'buy_date');

        if ($debtors) {
            $query->whereHas('debtors', function (Builder $query) use ($debtors) {
                $query->whereIn('id', $debtors);
            });
        }

        if ($tags) {
            $query->whereHas('tags', function (Builder $query) use ($tags) {
                $query->whereIn('tags.id', $tags);
            });
        }

        $query->with(['debtors', 'tags']);

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

    public function findById($id, bool $includeRelations = true, array $relations = []): ?Model
    {
        $query = $this->getQuery();

        if ($includeRelations) {
            $query->with(['tags', 'debtors', 'attachments', 'card']);

            $query->withCount([
                'payments AS payments_completed' => function ($query) {
                    $query->payed();
                },
            ]);
        }

        return $query->find($id);
    }
}
