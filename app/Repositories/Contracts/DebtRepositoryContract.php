<?php

namespace App\Repositories\Contracts;

interface DebtRepositoryContract extends RepositoryContract
{
    public function getAll(bool $paginate = false, int $take = 15, string $search = '', string $from = '', string $to = '', array $debtors = [], array $tags = []);
}
