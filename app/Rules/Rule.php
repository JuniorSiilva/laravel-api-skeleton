<?php

namespace App\Rules;

use App\Traits\InitializationServicesAndRepositories;

class Rule
{
    use InitializationServicesAndRepositories;

    public function __construct()
    {
        $this->bootInitializationServices();
    }
}
