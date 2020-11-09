<?php

namespace App\Services\Contracts;

interface DebtorServiceContract
{
    public function create(array $data) : int;

    public function update(array $data, $id) : int;

    public function generatePaymentsPdf(int $id, string $year, string $month);
}
