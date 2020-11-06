<?php

namespace App\Http\Requests;

use App\Enums\CardBrand;
use Illuminate\Validation\Rule;

class CreateCard extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'digits' => ['required', 'string', 'digits:4'],
            'brand' => ['required', Rule::in(CardBrand::getKeys())],
        ];
    }
}
