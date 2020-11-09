<?php

namespace App\Repositories\Contracts;

interface TagRepositoryContract extends RepositoryContract
{
    public function getAll(bool $paginate = false, int $take = 15, string $search = '');
}
