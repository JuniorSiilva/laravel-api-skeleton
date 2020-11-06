<?php

namespace App\Repositories\Contracts;

interface PaymentRepositoryContract extends RepositoryContract
{
    public function getAll(bool $paginate = false, int $take = 15, string $search = '', string $from = '', string $to = '', ?int $debtId = null, array $debtors = [], array $status = []);
}
