<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use App\Exceptions\BusinessException;
use Illuminate\Auth\Events\Registered;
use App\Services\Contracts\VerificationUserServiceContract;

final class VerificationUserService extends Service implements VerificationUserServiceContract
{
    public function verify($id)
    {
        $user = User::findOrFail($id);

        if ($user->hasVerifiedEmail()) {
            throw new BusinessException(__('messages.USER_ALREADY_VERIFIED'));
        }

        if ($user->markEmailAsVerified()) {
            // You can create listeners to capture this event and register them in \App\Events\EventServiceProdiver.
            event(new Verified($user));
        }
    }

    public function sendConfirmNotification(User $user)
    {
        event(new Registered($user));
    }
}
