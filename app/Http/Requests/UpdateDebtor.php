<?php

namespace App\Http\Requests;

class UpdateDebtor extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'phones' => ['nullable', 'array'],
            'phones.*' => ['required', 'string', 'max:15'],
        ];
    }
}
