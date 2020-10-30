<?php

namespace App\Services;

use App\Traits\InitializationServicesAndRepositories;

abstract class Service
{
    use InitializationServicesAndRepositories;

    public function __construct()
    {
        $this->bootInitializationServices();
    }
}
