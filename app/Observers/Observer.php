<?php

namespace App\Observers;

use App\Traits\InitializationServicesAndRepositories;

class Observer
{
    use InitializationServicesAndRepositories;

    public function __construct()
    {
        $this->bootInitializationServices();
    }
}
