<?php

namespace App\Services\Contracts;

interface DebtServiceContract
{
    public function create(array $data);

    public function update(int $id, array $data);
}
