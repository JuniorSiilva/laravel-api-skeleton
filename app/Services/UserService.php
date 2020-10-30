<?php

namespace App\Services;

use App\Models\User;
use App\Services\Contracts\UserServiceContract;
use App\Repositories\Contracts\UserRepositoryContract;

final class UserService extends Service implements UserServiceContract
{
    /**
     * @var \App\Repositories\UserRepository
     */
    protected $userRepository = UserRepositoryContract::class;

    public function register(array $data)
    {
        $user = User::create($data);

        return $user->getKey();
    }

    public function updateProfile(array $data)
    {
        $user = $this->userRepository->findById(current_user_id(), false);

        $user->fill($data);

        $user->save();

        return $user->getKey();
    }

    public function resetPassword(User $user, string $password)
    {
        $user->setPassword($password);

        $user->save();
    }
}
