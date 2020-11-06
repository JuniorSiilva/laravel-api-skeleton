<?php

namespace App\Providers;

use App\Repositories\CardRepository;
use App\Repositories\UserRepository;
use App\Repositories\DebtorRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\CardRepositoryContract;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\Contracts\DebtorRepositoryContract;

class RepositoryBindServiceProvider extends ServiceProvider
{
    protected $repositories = [
        UserRepositoryContract::class => UserRepository::class,
        CardRepositoryContract::class => CardRepository::class,
        DebtorRepositoryContract::class => DebtorRepository::class,
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
