<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'installment' => $this->installment,
            'status' => $this->status,
            'payment_date' => $this->payment_date,
            'receipt_date' => $this->receipt_date,
            'debt' => new DebtResource($this->whenLoaded('debt')),
            'debtor' => new DebtorResource($this->whenLoaded('debtor')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
