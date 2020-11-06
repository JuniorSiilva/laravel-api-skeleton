<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DebtResource extends JsonResource
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
            'description' => $this->description,
            'price' => $this->price,
            'buy_date' => $this->buy_date,
            'payment_start_date' => $this->payment_start_date,
            'installments' => $this->installments,
            'payments_completed' => $this->payments_completed,
            'status' => $this->status,
            'card' => new CardResource($this->whenLoaded('card')),
            'debtors' => DebtorResource::collection($this->whenLoaded('debtors')),
            'attachments' => AttachmentResource::collection($this->whenLoaded('attachments')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
