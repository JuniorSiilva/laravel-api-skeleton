<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Requests\CreateDebtor;
use App\Http\Requests\UpdateDebtor;
use App\Http\Resources\DebtorResource;
use App\Http\Requests\DefaultListRequest;
use App\Services\Contracts\DebtorServiceContract;
use App\Repositories\Contracts\DebtorRepositoryContract;

class DebtorController extends Controller
{
    /**
     * @var \App\Repositories\DebtorRepository
     */
    protected $debtorRepository = DebtorRepositoryContract::class;

    /**
     * @var \App\Services\DebtorService
     */
    protected $debtorService = DebtorServiceContract::class;

    public function get(DefaultListRequest $request)
    {
        $search = $request->inputOr('search', '');
        $take = $request->inputOr('take', 10);

        $debtors = $this->debtorRepository->getAll(true, $take, $search);

        return response($debtors)->withResource(DebtorResource::class);
    }

    public function find(int $id)
    {
        $debtor = $this->debtorRepository->findById($id);

        return response($debtor)->withResource(DebtorResource::class);
    }

    public function create(CreateDebtor $request)
    {
        $debtorId = $this->debtorService->create($request->validated());

        return response(['id' => $debtorId], Response::HTTP_CREATED);
    }

    public function update(UpdateDebtor $request, int $id)
    {
        $debtorId = $this->debtorService->update($request->validated(), $id);

        return response(['id' => $debtorId]);
    }

    public function payments(int $debtorId, string $year, string $month)
    {
        $pdfFile = $this->debtorService->generatePaymentsPdf($debtorId, $year, $month);

        if (! $pdfFile) {
            return response(false, Response::HTTP_NO_CONTENT);
        }

        return $pdfFile->download("{$month}_{$year}.pdf");
    }
}
