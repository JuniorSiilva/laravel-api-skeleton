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
        $debtor = $this->save(new Debtor, $data);

        return $debtor->getKey();
    }

    public function update(array $data, $id) : int
    {
        $debtor = $this->save($this->debtorRepository->findById($id, false), $data);

        return $debtor->getKey();
    }

    protected function save(Debtor $debtor, array $data) : Debtor
    {
        $debtor->fill($data);

        $debtor->save();

        return $debtor;
    }
}
