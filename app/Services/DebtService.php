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

            $valuePerDebtor = $data['price'] / count($data['debtors']);

            foreach ($data['debtors'] as $debtor) {
                $this->paymentService->create($debt, $debtor['id'], $valuePerDebtor);
            }

            $debt->debtors()->sync(array_column($data['debtors'] ?? [], 'id'));

            $debt->tags()->sync(array_column($data['tags'] ?? [], 'id'));

            $this->attachmentService->createMany($debt, $data['attachments'] ?? []);
        });

        return $debt->getKey();
    }
}
