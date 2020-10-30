<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Requests\Authenticate;
use App\Http\Resources\PersonalTokenResource;
use App\Services\Contracts\AuthServiceContract;

class AuthController extends Controller
{
    /**
     * @var \App\Services\AuthService
     */
    protected $authService = AuthServiceContract::class;

    public function login(Authenticate $request)
    {
        $token = $this->authService->authenticate($request->validated());

        return response(['token' => $token]);
    }

    public function tokens()
    {
        $tokens = $this->authService->getUserTokens();

        return response($tokens)->withResource(PersonalTokenResource::class);
    }

    public function revoke(int $id)
    {
        $this->authService->revokeToken($id);

        return response(false, Response::HTTP_NO_CONTENT);
    }

    public function logout()
    {
        $this->authService->logout();

        return response(false, Response::HTTP_NO_CONTENT);
    }
}
