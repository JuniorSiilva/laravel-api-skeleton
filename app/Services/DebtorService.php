<?php

namespace App\Services;

use App\Models\Debtor;
use App\Services\Contracts\DebtorServiceContract;
use App\Repositories\Contracts\DebtorRepositoryContract;

class DebtorService extends Service implements DebtorServiceContract
{
    /**
     * @var \App\Repositories\DebtorRepository
     */
    protected $debtorRepository = DebtorRepositoryContract::class;

    public function create(array $data) : int
    {
        return $this->save(new Debtor, $data);
    }

    public function update(array $data, $id) : int
    {
        return $this->save($this->debtorRepository->findById($id, false), $data);
    }

    protected function save(Debtor $debtor, array $data) : int
    {
        $debtor->fill($data);

        $debtor->save();

        return $debtor->getKey();
    }
}
