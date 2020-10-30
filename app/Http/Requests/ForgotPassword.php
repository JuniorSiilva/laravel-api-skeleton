<?php

namespace App\Http\Requests;

class ForgotPassword extends Request
{
    public function rules()
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
        ];
    }
}
