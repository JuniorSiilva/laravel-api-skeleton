<?php

namespace App\Repositories\Contracts;

interface DebtorRepositoryContract extends RepositoryContract
{
    public function getAll(bool $paginate = false, int $take = 15, string $search = '');
}
