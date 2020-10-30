<?php

namespace App\Services;

use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Auth\PasswordBroker;
use App\Services\Contracts\UserServiceContract;
use App\Services\Contracts\ForgotPasswordContract;
use App\Repositories\Contracts\UserRepositoryContract;

class ForgotPasswordService extends Service implements ForgotPasswordContract
{
    /**
     * @var \App\Services\UserService
     */
    protected $userService = UserServiceContract::class;

    /**
     * @var \App\Repositories\UserRepository
     */
    protected $userRepository = UserRepositoryContract::class;

    public function sendResetLink(array $data)
    {
        if (! $this->userRepository->findByEmail($data['email'])) {
            throw new BusinessException(__('messages.USER_NOT_FOUND'));
        }

        return $this->broker()->sendResetLink($data);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return PasswordBroker
     */
    protected function broker()
    {
        return Password::broker();
    }

    public function resetPassword(array $data)
    {
        if (! $this->userRepository->findByEmail($data['email'])) {
            throw new BusinessException(__('messages.USER_NOT_FOUND'));
        }

        $response = $this->broker()->reset(
            $data,
            function ($user, $password) {
                $this->userService->resetPassword($user, $password);
            }
        );

        if ($response !== Password::PASSWORD_RESET) {
            throw new BusinessException(__($response));
        }
    }
}
