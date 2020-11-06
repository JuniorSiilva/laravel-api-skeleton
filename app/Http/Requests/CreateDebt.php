<?php

namespace App\Http\Requests;

use App\Rules\Decimal;
use App\Enums\AttachmentExtension;

class CreateDebt extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => ['required', 'string', 'max:50'],
            'buy_date' => ['required', 'date', 'date_format:"Y-m-d"'],
            'payment_start_date' => ['required', 'date', 'date_format:"Y-m-d"'],
            'installments' => ['required', 'integer', 'min:1', 'max:360'],
            'price' => ['required', 'numeric', 'min:0', new Decimal],
            'card.id' => ['nullable', 'integer', 'exists:cards,id,owner_id,' . current_user_id()],
            'debtors' => ['required', 'array', 'min:1'],
            'debtors.*.id' => ['required', 'integer', 'exists:debtors,id,owner_id,' . current_user_id()],
            'attachments' => ['nullable', 'array'],
            'attachments.*.file' => ['required', 'file', 'mimes:' . AttachmentExtension::availableMimeTypes()],
            'attachments.*.description' => ['nullable', 'string', 'max:255'],
        ];
    }
}
