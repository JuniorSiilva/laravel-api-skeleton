<?php

namespace App\Services;

use App\Services\Contracts\DebtServiceContract;
use App\Repositories\Contracts\DebtRepositoryContract;

class DebtService extends Service implements DebtServiceContract
{
    /**
     * @var \App\Repositories\DebtRepository
     */
    protected $debtRepository = DebtRepositoryContract::class;
}
