<?php

namespace App\Services\Contracts;

use App\Models\User;

interface UserServiceContract
{
    public function register(array $data);

    public function updateProfile(array $data);

    public function resetPassword(User $user, string $password);
}
