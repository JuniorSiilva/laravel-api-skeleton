<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Requests\CreateUser;
use App\Http\Requests\UpdateProfile;
use App\Http\Resources\UserResource;
use App\Services\Contracts\UserServiceContract;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Services\Contracts\VerificationUserServiceContract;

class UserController extends Controller
{
    /**
     * @var \App\Repositories\UserRepository
     */
    protected $userRepository = UserRepositoryContract::class;

    /**
     * @var \App\Services\UserService
     */
    protected $userService = UserServiceContract::class;

    /**
     * @var \App\Services\VerificationUserService
     */
    protected $verificationService = VerificationUserServiceContract::class;

    public function register(CreateUser $request)
    {
        $user = $this->userService->register($request->validated());

        return response(['id' => $user], Response::HTTP_CREATED);
    }

    public function verify($id)
    {
        $this->verificationService->verify($id);

        return response(false, Response::HTTP_NO_CONTENT);
    }

    public function profileUpdate(UpdateProfile $request)
    {
        $this->userService->updateProfile($request->validated());

        return response(false, Response::HTTP_NO_CONTENT);
    }

    public function profile()
    {
        $user = $this->userRepository->getUserProfile(current_user_id());

        return response($user)->withResource(UserResource::class);
    }
}
