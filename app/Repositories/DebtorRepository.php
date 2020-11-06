<?php

namespace App\Repositories;

use App\Models\Debtor;
use App\Repositories\Contracts\DebtorRepositoryContract;

class DebtorRepository extends Repository implements DebtorRepositoryContract
{
    protected $model = Debtor::class;

    public function getAll(bool $paginate = false, int $take = 15, string $search = '')
    {
        $query = $this->getQuery();

        $query->where('name', 'ILIKE', "%$search%")
            ->orWhere('email', 'ILIKE', "%$search%");

        $query->orderBy('name', 'ASC');

        if ($paginate) {
            return $query->paginate($take);
        }

        return $query->get();
    }
}
