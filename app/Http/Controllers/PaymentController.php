<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListPayments;
use App\Http\Resources\PaymentResource;
use App\Repositories\Contracts\PaymentRepositoryContract;

class PaymentController extends Controller
{
    /**
     * @var \App\Repositories\PaymentRepository
     */
    protected $paymentRepository = PaymentRepositoryContract::class;

    public function get(ListPayments $request)
    {
        $search = $request->inputOr('search', '');
        $debt = $request->inputOr('debt', null);
        $from = $request->inputOr('from', '');
        $to = $request->inputOr('to', '');
        $take = $request->inputOr('take', 10);
        $debtors = $request->inputOr('debtors', []);
        $status = $request->inputOr('status', []);

        $payments = $this->paymentRepository->getAll(true, $take, $search, $from, $to, $debt, $debtors, $status);

        return response($payments)->withResource(PaymentResource::class);
    }

    public function find(int $id)
    {
        $payment = $this->paymentRepository->findById($id);

        return response($payment)->withResource(PaymentResource::class);
    }
}
