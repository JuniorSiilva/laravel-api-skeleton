<?php

namespace App\Services;

use DB;
use App\Models\Debt;
use App\Services\Contracts\DebtServiceContract;
use App\Services\Contracts\PaymentServiceContract;
use App\Services\Contracts\AttachmentServiceContract;
use App\Repositories\Contracts\DebtRepositoryContract;

class DebtService extends Service implements DebtServiceContract
{
    /**
     * @var \App\Repositories\DebtRepository
     */
    protected $debtRepository = DebtRepositoryContract::class;

    /**
     * @var \App\Services\AttachmentService
     */
    protected $attachmentService = AttachmentServiceContract::class;

    /**
     * @var \App\Services\PaymentService
     */
    protected $paymentService = PaymentServiceContract::class;

    public function create(array $data)
    {
        $debt = new Debt($data);

        DB::transaction(function () use ($debt, $data) {
            $debt->card()->associate($data['card']['id'] ?? null);

            $debt->save();

            $debtorsId = array_column($data['debtors'] ?? [], 'id');

            $this->createDebtorsPayments($debt, $debtorsId, $data['price']);

            $debt->debtors()->sync($debtorsId);

            $debt->tags()->sync(array_column($data['tags'] ?? [], 'id'));

            $this->attachmentService->createMany($debt, $data['attachments'] ?? []);
        });

        return $debt->getKey();
    }

    private function createDebtorsPayments(Debt $debt, array $debtorsId, float $totalPrice)
    {
        $valuePerDebtor = $totalPrice / count($debtorsId);

        foreach ($debtorsId as $debtorId) {
            $this->paymentService->create($debt, $debtorId, $valuePerDebtor);
        }
    }

    public function update(int $id, array $data)
    {
        $debt = $this->debtRepository->findById($id, false);

        DB::transaction(function () use ($debt, $data) {
            $debt->fill($data);

            $debt->card()->associate($data['card']['id'] ?? null);

            $debt->tags()->sync(array_column($data['tags'] ?? [], 'id'));

            $this->attachmentService->createMany($debt, $data['attachments'] ?? []);

            $debt->save();
        });

        return $debt->getKey();
    }
}
