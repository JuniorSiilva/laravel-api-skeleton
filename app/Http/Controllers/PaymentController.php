<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListPayments;
use App\Http\Resources\PaymentResource;
use App\Http\Requests\DefaultListRequest;
use App\Services\Contracts\PaymentServiceContract;
use App\Http\Resources\CommonRelationReferenceResource;
use App\Repositories\Contracts\DebtorRepositoryContract;
use App\Repositories\Contracts\PaymentRepositoryContract;

class PaymentController extends Controller
{
    /**
     * @var \App\Repositories\PaymentRepository
     */
    protected $paymentRepository = PaymentRepositoryContract::class;

    /**
     * @var \App\Repositories\DebtorRepository
     */
    protected $debtorRepository = DebtorRepositoryContract::class;

    /**
     * @var \App\Services\PaymentService
     */
    protected $paymentService = PaymentServiceContract::class;

    public function get(ListPayments $request)
    {
        $search = $request->inputOr('search', '');
        $debt = $request->inputOr('debt', null);
        $from = $request->inputOr('from', '');
        $to = $request->inputOr('to', '');
        $take = $request->inputOr('take', 10);
        $debtors = $request->inputOr('debtors', []);
        $status = $request->inputOr('status', []);
        $tags = $request->inputOr('tags', []);

        $payments = $this->paymentRepository->getAll(true, $take, $search, $from, $to, $debt, $debtors, $status, $tags);

        return response($payments)->withResource(PaymentResource::class);
    }

    public function find(int $id)
    {
        $payment = $this->paymentRepository->findById($id);

        return response($payment)->withResource(PaymentResource::class);
    }

    public function togglePayment(int $id)
    {
        $paymentId = $this->paymentService->toggle($id);

        return response(['id' => $paymentId]);
    }

    public function debtors(DefaultListRequest $request)
    {
        $search = $request->inputOr('search', '');

        $debtors = $this->debtorRepository->getAll(false, 15, $search);

        return response($debtors)->withResource(CommonRelationReferenceResource::class);
    }
}
