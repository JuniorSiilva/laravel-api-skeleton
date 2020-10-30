<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\BusinessException;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Services\Contracts\AuthServiceContract;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Services\Contracts\VerificationUserServiceContract;

final class AuthService extends Service implements AuthServiceContract
{
    /**
     * @var \App\Repositories\UserRepository
     */
    protected $userRepository = UserRepositoryContract::class;

    /**
     * @var \App\Services\VerificationUserService
     */
    protected $verificationUserService = VerificationUserServiceContract::class;

    public function authenticate(array $credentials)
    {
        $user = $this->userRepository->findByEmail($credentials['username']);

        $this->validateUserBeforeAuthenticate($user, $credentials);

        return $this->getToken($user);
    }

    protected function validateUserBeforeAuthenticate(?User $user, array $credentials)
    {
        if (! $user || ! Hash::check($credentials['password'], $user->getPassword())) {
            throw new BusinessException(__('auth.failed'), Response::HTTP_UNAUTHORIZED);
        }

        if ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
            $this->verificationUserService->sendConfirmNotification($user);

            throw new BusinessException(__('auth.unconfirmed'), Response::HTTP_UNAUTHORIZED);
        }
    }

    protected function getToken(User $user)
    {
        $token = $user->createToken('API')->plainTextToken;

        return $token;
    }

    public function getUserTokens()
    {
        return $this->authenticatedUser()->tokens()->get();
    }

    public function logout()
    {
        $user = $this->authenticatedUser();

        $user->currentAccessToken()->delete();
    }

    public function revokeToken(int $id)
    {
        $user = $this->authenticatedUser();

        $user->tokens()->whereId($id)->delete();
    }

    public function revokeAllTokens(User $user)
    {
        $tokens = $user->tokens();

        if ($this->authenticatedUserId() && $currentAccessToken = $this->authenticatedUser()->currentAccessToken()) {
            $tokens->where('token', '!=', $currentAccessToken->token);
        }

        $tokens->delete();
    }

    public function authenticatedUserId()
    {
        return Auth::id();
    }

    public function authenticatedUser()
    {
        return Auth::user();
    }
}
