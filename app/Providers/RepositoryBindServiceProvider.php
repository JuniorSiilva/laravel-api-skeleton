<?php

namespace App\Providers;

use App\Repositories\TagRepository;
use App\Repositories\CardRepository;
use App\Repositories\DebtRepository;
use App\Repositories\UserRepository;
use App\Repositories\DebtorRepository;
use App\Repositories\PaymentRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\TagRepositoryContract;
use App\Repositories\Contracts\CardRepositoryContract;
use App\Repositories\Contracts\DebtRepositoryContract;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\Contracts\DebtorRepositoryContract;
use App\Repositories\Contracts\PaymentRepositoryContract;

class RepositoryBindServiceProvider extends ServiceProvider
{
    protected $repositories = [
        UserRepositoryContract::class => UserRepository::class,
        CardRepositoryContract::class => CardRepository::class,
        DebtorRepositoryContract::class => DebtorRepository::class,
        DebtRepositoryContract::class => DebtRepository::class,
        PaymentRepositoryContract::class => PaymentRepository::class,
        TagRepositoryContract::class => TagRepository::class,
    ];

    /**
     * Register repositories.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $contract => $service) {
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
