<?php

namespace App\Providers;

use App\Services\AuthService;
use App\Services\UserService;
use App\Services\ForgotPasswordService;
use Illuminate\Support\ServiceProvider;
use App\Services\VerificationUserService;
use App\Services\Contracts\AuthServiceContract;
use App\Services\Contracts\UserServiceContract;
use App\Services\Contracts\ForgotPasswordContract;
use App\Services\Contracts\VerificationUserServiceContract;

class ServicesBindProvider extends ServiceProvider
{
    protected $services = [
        AuthServiceContract::class => AuthService::class,
        UserServiceContract::class => UserService::class,
        VerificationUserServiceContract::class => VerificationUserService::class,
        ForgotPasswordContract::class => ForgotPasswordService::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->services as $contract => $service) {
            $this->app->singleton($contract, $service);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
