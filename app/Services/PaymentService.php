<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Debt;
use App\Models\Payment;
use App\Enums\PaymentStatus;
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
        $paymentDate = Carbon::parse($debt->getStartDate());

        $price = $debt->getInstallments() === 1 ? $totalValue : $totalValue / $debt->getInstallments();

        for ($installment = 1; $installment <= $debt->getInstallments(); $installment++) {
            $payment = new Payment([
                'installment' => $installment,
                'price' => $price,
                'payment_date' => $installment === 1 ? $debt->getStartDate() : $paymentDate->addMonthsNoOverflow(1),
            ]);

            $payment->debt()->associate($debt);

            $payment->debtor()->associate($debtorId);

            $payment->save();
        }
    }

    public function pay(int $id)
    {
        $payment = $this->paymentRepository->findById($id, false);

        if ($payment->isPaid()) {
            return $payment->getKey();
        }

        $payment->setStatus(PaymentStatus::PAGO);
        $payment->setReceiptDate(date('Y-m-d'));
        $payment->save();

        return $payment->getKey();
    }

    public function unpay(int $id)
    {
        $payment = $this->paymentRepository->findById($id, false);

        if (! $payment->isPaid()) {
            return $payment->getKey();
        }

        $payment->setStatus(PaymentStatus::PENDENTE);
        $payment->setReceiptDate(null);
        $payment->save();

        return $payment->getKey();
    }
}
