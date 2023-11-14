<?php

namespace App\Enums;

abstract class Enum
{
  public static function cases()
  {
    return collect((new \ReflectionClass(static::class))->getConstants())->values()->all();
  }
}
