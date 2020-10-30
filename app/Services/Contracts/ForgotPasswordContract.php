<?php

namespace App\Services\Contracts;

interface ForgotPasswordContract
{
    public function sendResetLink(array $data);

    public function resetPassword(array $data);
}
