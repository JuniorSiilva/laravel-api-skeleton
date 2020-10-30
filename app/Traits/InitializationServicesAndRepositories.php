<?php

namespace App\Traits;

use ReflectionClass;

trait InitializationServicesAndRepositories
{
    protected function bootInitializationServices()
    {
        $props = (new ReflectionClass(static::class))->getProperties();

        $props = preg_grep('/Service$|Repository$/', array_column($props, 'name'));

        foreach ($props as $prop) {
            if (! empty($prop)) {
                $this->{$prop} = app($this->{$prop});
            }
        }
    }
}
