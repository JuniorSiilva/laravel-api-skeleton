<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Contracts\UserRepositoryContract;

class UserRepository extends Repository implements UserRepositoryContract
{
    protected $model = User::class;

    public function getAll(bool $paginate = false, int $take = 15, ?string $search = '')
    {
        $query = $this->getQuery();
        $query->where('name', 'ILIKE', "%$search%");
        $query->orderBy('name', 'ASC');

        if ($paginate) {
            return $query->paginate($take);
        }

        return $query->get();
    }

    public function getUserProfile(int $id): User
    {
        return $this->getQuery()->with('roles.permissions')->findOrFail($id);
    }

    public function findById($id, bool $includeRelations = true, array $relations = ['roles.permissions', 'regions']): ?Model
    {
        return parent::findById($id, $includeRelations, $relations);
    }

    public function findByEmail(string $email = ''): ?User
    {
        return $this->getQuery()->whereEmail($email)->first();
    }
}
