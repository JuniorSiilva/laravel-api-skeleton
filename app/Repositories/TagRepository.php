<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Repositories\Contracts\TagRepositoryContract;

class TagRepository extends Repository implements TagRepositoryContract
{
    protected $model = Tag::class;

    public function getAll(bool $paginate = false, int $take = 15, string $search = '')
    {
        $query = $this->getQuery();

        $query->where('name', 'ILIKE', "%$search%");

        return $query->get();
    }
}
