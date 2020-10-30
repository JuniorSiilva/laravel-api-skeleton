<?php

namespace App\Http\Requests;

class UpdateProfile extends Request
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ];
    }
}
