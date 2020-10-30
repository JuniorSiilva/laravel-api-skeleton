<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Contracts\RepositoryContract;

abstract class Repository implements RepositoryContract
{
    /**
     * Required.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getQuery()
    {
        return $this->getModel()->query();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function getModel()
    {
        return app($this->model);
    }

    public function getAll(bool $paginate = false, int $take = 15)
    {
        $query = $this->getQuery();

        if ($paginate) {
            return $query->paginate($take);
        }

        return $query->get();
    }

    public function findById($id, bool $includeRelations = true, array $relations = []): ?Model
    {
        $query = $this->getQuery();

        if ($includeRelations) {
            $query->with($relations);
        }

        return $query->find($id);
    }
}
