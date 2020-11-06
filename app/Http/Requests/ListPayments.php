<?php

namespace App\Http\Requests;

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
            'debt' => ['nullable', 'integer', 'exists:debtors,id'],
        ]);
    }
}
