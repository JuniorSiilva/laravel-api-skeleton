<?php

namespace App\Services;

use App\Models\Debt;
use App\Models\Payment;
use App\Services\Contracts\PaymentServiceContract;
use App\Repositories\Contracts\PaymentRepositoryContract;

class PaymentService extends Service implements PaymentServiceContract
{
    /**
     * @var \App\Repositories\PaymentRepository
     */
    protected $paymentRepository = PaymentRepositoryContract::class;

    public function create(Debt $debt, int $debtorId, float $totalValue)
    {
        $price = $debt->getInstallments() === 1 ? $totalValue : $totalValue / $debt->getInstallments();

        for ($installment = 1; $installment <= $debt->getInstallments(); $installment++) {
            $payment = new Payment([
                'installment' => $installment,
                'price' => $price,
                'payment_date' => $installment === 1 ? $debt->getStartDate() : $debt->getStartDate()->addMonthsNoOverflow(1),
            ]);

            $payment->debt()->associate($debt);

            $payment->debtor()->associate($debtorId);

            $payment->save();
        }
    }

    public function toggle(int $id)
    {
        $payment = $this->paymentRepository->findById($id, false);

        if ($payment->isPaid()) {
            $payment->unpay();
        } else {
            $payment->pay();
        }

        return $payment->getKey();
    }
}
