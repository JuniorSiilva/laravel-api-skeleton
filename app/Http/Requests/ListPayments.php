<?php

namespace App\Http\Requests;

use App\Enums\PaymentStatus;
use Illuminate\Validation\Rule;

class ListPayments extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(DefaultListRequest $request)
    {
        return array_merge($request->rules(), [
            'status' => ['nullable', 'array'],
            'status.*' => ['required', Rule::in(PaymentStatus::getKeys())],
            'debtors' => ['nullable', 'array'],
            'debtors.*' => ['required', 'integer', 'exists:debtors,id'],
            'debt' => ['nullable', 'integer', 'exists:debtors,id'],
        ]);
    }
}
