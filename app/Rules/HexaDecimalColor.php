<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class HexaDecimalColor implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^((0x){0,1}|#{0,1})([0-9A-F]{8}|[0-9A-F]{6})$/i', $value) === 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.regex');
    }
}
