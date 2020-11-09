<?php

namespace App\Providers;

use App\Services\PDFService;
use App\Services\AuthService;
use App\Services\CardService;
use App\Services\DebtService;
use App\Services\UserService;
use App\Services\DebtorService;
use App\Services\PaymentService;
use App\Services\AttachmentService;
use App\Services\ForgotPasswordService;
use Illuminate\Support\ServiceProvider;
use App\Services\VerificationUserService;
use App\Services\Contracts\PDFServiceContract;
use App\Services\Contracts\AuthServiceContract;
use App\Services\Contracts\CardServiceContract;
use App\Services\Contracts\DebtServiceContract;
use App\Services\Contracts\UserServiceContract;
use App\Services\Contracts\DebtorServiceContract;
use App\Services\Contracts\ForgotPasswordContract;
use App\Services\Contracts\PaymentServiceContract;
use App\Services\Contracts\AttachmentServiceContract;
use App\Services\Contracts\VerificationUserServiceContract;

class ServicesBindServiceProvider extends ServiceProvider
{
    protected $services = [
        AuthServiceContract::class => AuthService::class,
        UserServiceContract::class => UserService::class,
        VerificationUserServiceContract::class => VerificationUserService::class,
        ForgotPasswordContract::class => ForgotPasswordService::class,
        CardServiceContract::class => CardService::class,
        DebtorServiceContract::class => DebtorService::class,
        DebtServiceContract::class => DebtService::class,
        AttachmentServiceContract::class => AttachmentService::class,
        PaymentServiceContract::class => PaymentService::class,
        PDFServiceContract::class => PDFService::class,
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
