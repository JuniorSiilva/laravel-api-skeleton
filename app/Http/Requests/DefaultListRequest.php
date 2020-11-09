<?php

namespace App\Http\Requests;

class DefaultListRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'search' => ['nullable', 'string'],
            'take' => ['nullable', 'integer', 'min:3', 'max:100'],
            'paginate' => ['nullable', 'boolean'],
            'from' => ['nullable', 'date', 'date_format:"Y-m-d"'],
            'to' => ['nullable', 'date', 'date_format:"Y-m-d"'],
        ];
    }
}
