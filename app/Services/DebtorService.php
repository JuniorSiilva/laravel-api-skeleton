<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Debtor;
use App\Services\Contracts\PDFServiceContract;
use App\Services\Contracts\DebtorServiceContract;
use App\Repositories\Contracts\DebtorRepositoryContract;
use App\Repositories\Contracts\PaymentRepositoryContract;

class DebtorService extends Service implements DebtorServiceContract
{
    /**
     * @var \App\Repositories\DebtorRepository
     */
    protected $debtorRepository = DebtorRepositoryContract::class;

    /**
     * @var \App\Repositories\PaymentRepository
     */
    protected $paymentRepository = PaymentRepositoryContract::class;

    /**
     * @var \App\Services\PDFService
     */
    protected $pdfService = PDFServiceContract::class;

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

    public function generatePaymentsPdf(int $id, string $year, string $month)
    {
        $debtor = $this->debtorRepository->findById($id, false);

        $payments = $this->paymentRepository->getFromYearMonthAndDebtor($id, $year, $month);

        if ($payments->isEmpty()) {
            return;
        }

        $pdfFile = $this->pdfService->generate('debtor-payment-pdf', [
            'debtor' => $debtor,
            'payments' => $payments,
            'period' => Carbon::parse("$year-$month-01"),
            'month' => $month,
            'year' => $year,
            'total' => 0,
        ]);

        return $pdfFile;
    }

    protected function save(Debtor $debtor, array $data) : Debtor
    {
        $debtor->fill($data);

        $debtor->save();

        return $debtor;
    }
}
