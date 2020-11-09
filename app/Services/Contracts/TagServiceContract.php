<?php

namespace App\Services\Contracts;

interface TagServiceContract
{
    public function create(array $data) : int;
}
