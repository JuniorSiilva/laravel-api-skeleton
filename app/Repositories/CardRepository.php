<?php

namespace App\Repositories;

use App\Models\Card;
use App\Repositories\Contracts\CardRepositoryContract;

class CardRepository extends Repository implements CardRepositoryContract
{
    protected $model = Card::class;

    public function getAll(bool $paginate = false, int $take = 15, string $search = '')
    {
        $query = $this->getQuery();

        $query->where('digits', 'ILIKE', "%$search%");

        if ($paginate) {
            return $query->paginate($take);
        }

        return $query->get();
    }
}
