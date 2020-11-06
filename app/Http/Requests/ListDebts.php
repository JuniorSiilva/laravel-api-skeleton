<?php

namespace App\Http\Requests;

class ListDebts extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(DefaultListRequest $request)
    {
        return array_merge($request->rules(), [
            'debtors' => ['nullable', 'array'],
            'debtors.*' => ['required', 'integer', 'exists:debtors,id'],
        ]);
    }
}
