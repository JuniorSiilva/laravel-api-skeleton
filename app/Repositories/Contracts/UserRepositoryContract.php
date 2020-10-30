<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryContract extends RepositoryContract
{
    public function getAll(bool $paginate = false, int $take = 15, ?string $search = '');

    public function getUserProfile(int $id): User;

    public function findByEmail(string $email = ''): ?User;
}
