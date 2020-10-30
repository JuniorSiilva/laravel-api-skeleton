<?php

namespace App\Services\Contracts;

use App\Models\User;

interface VerificationUserServiceContract
{
    public function verify($id);

    public function sendConfirmNotification(User $user);
}
