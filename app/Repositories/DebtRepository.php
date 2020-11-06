<?php

namespace App\Repositories;

use App\Models\Debt;
use App\Repositories\Contracts\DebtRepositoryContract;

class DebtRepository extends Repository implements DebtRepositoryContract
{
    protected $model = Debt::class;
}
