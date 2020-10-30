<?php

namespace App\Enums;

use ReflectionClass;

abstract class Enum
{
    /**
     * Exibe todas as chaves e valores (key => values) da class (static) chamada.
     */
    public static function toArray(): array
    {
        return self::getConstants();
    }

    /**
     * Exibe todas as constances da class (static) chamada.
     */
    private static function getConstants(): array
    {
        return (new ReflectionClass(static::class))->getConstants();
    }

    /**
     * Exibe um valor (value) baseado na chave (key) recebida.
     */
    public static function getValue($key): ?string
    {
        return in_array($key, self::getKeys()) ? self::getConstants()[$key] : null;
    }

    /**
     * Exibe todas as chaves (keys) da class (static) chamada.
     */
    public static function getKeys(): array
    {
        return array_keys(self::getConstants());
    }

    /**
     * Exibe uma chave (key) baseado no valor (value) recebida.
     */
    public static function getKey($value): ?string
    {
        return in_array($value, self::getValues()) ? array_search($value, self::getConstants(), true) : null;
    }

    /**
     * Exibe todos os valores (values) da class (static) chamada.
     */
    public static function getValues(): array
    {
        return array_values(self::getConstants());
    }
}
