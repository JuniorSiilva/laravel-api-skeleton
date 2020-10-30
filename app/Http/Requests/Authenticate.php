<?php

namespace App\Http\Requests;

class Authenticate extends Request
{
    public function rules()
    {
        return [
            'username' => ['required', 'email'],
            'password' => ['required'],
        ];
    }
}
