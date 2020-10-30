<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Requests\ResetPassword;
use App\Http\Requests\ForgotPassword;
use App\Services\Contracts\ForgotPasswordContract;

class ForgotPasswordController extends Controller
{
    /**
     * @var \App\Services\ForgotPasswordService
     */
    protected $forgotPasswordService = ForgotPasswordContract::class;

    public function lost(ForgotPassword $request)
    {
        $this->forgotPasswordService->sendResetLink(
            $request->only('email')
        );

        return response(false, Response::HTTP_NO_CONTENT);
    }

    public function reset(ResetPassword $request)
    {
        $this->forgotPasswordService->resetPassword(
            $request->validated()
        );

        return response(false, Response::HTTP_NO_CONTENT);
    }
}
