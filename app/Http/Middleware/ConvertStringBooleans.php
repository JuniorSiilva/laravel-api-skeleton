<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TransformsRequest;

class ConvertStringBooleans extends TransformsRequest
{
    /**
     * Transform the given value.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function transform($key, $value)
    {
        if (is_string($value) && strtolower($value) === 'true') {
            return true;
        } elseif (is_string($value) && strtolower($value) === 'false') {
            return false;
        }

        return $value;
    }
}
