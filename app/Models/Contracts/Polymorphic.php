<?php

namespace App\Models\Contracts;

interface Polymorphic
{
    public function getClass(): string;

    public function getKey();
}
