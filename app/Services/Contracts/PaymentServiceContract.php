<?php

namespace App\Services\Contracts;

use App\Models\Debt;

interface PaymentServiceContract
{
    public function create(Debt $debt, int $debtorId, float $totalValue);

    public function toggle(int $id);
}
