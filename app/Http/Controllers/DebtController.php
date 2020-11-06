<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Requests\CreateDebt;
use App\Http\Resources\DebtResource;
use App\Http\Requests\DefaultListRequest;
use App\Services\Contracts\DebtServiceContract;
use App\Repositories\Contracts\DebtRepositoryContract;

class DebtController extends Controller
{
    /**
     * @var \App\Repositories\DebtRepository
     */
    protected $debtRepository = DebtRepositoryContract::class;

    /**
     * @var \App\Services\DebtService
     */
    protected $debtService = DebtServiceContract::class;

    public function get(DefaultListRequest $request)
    {
        $search = $request->inputOr('search', '');
        $take = $request->inputOr('take', 10);

        $debts = $this->debtRepository->getAll(true, $take, $search);

        return response($debts)->withResource(DebtResource::class);
    }

    public function find(int $id)
    {
        $debt = $this->debtRepository->findById($id);

        return response($debt)->withResource(DebtResource::class);
    }

    public function create(CreateDebt $request)
    {
        $debtId = $this->debtService->create($request->validated());

        return response(['id' => $debtId], Response::HTTP_CREATED);
    }
}
