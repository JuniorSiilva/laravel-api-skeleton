<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

interface RepositoryContract
{
    public function getAll(bool $paginate = false, int $take = 15);

    public function findById($id, bool $includeRelations = true, array $relations = []): ?Model;
}
