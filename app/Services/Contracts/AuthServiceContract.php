<?php

namespace App\Services\Contracts;

use App\Models\User;

interface AuthServiceContract
{
    public function authenticate(array $credentials);

    public function logout();

    public function getUserTokens();

    public function revokeToken(int $id);

    public function revokeAllTokens(User $user);

    public function authenticatedUserId();

    public function authenticatedUser();
}
