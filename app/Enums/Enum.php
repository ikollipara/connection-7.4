<?php

namespace App\Enums;

abstract class Enum
{
    /**
     *  @return array<string, mixed>
     */
    public static function cases()
    {
        return collect((new \ReflectionClass(static::class))->getConstants())
            ->values()
            ->all();
    }
}
