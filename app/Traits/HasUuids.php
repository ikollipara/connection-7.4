<?php

namespace App\Traits;

use Illuminate\Support\Str;

/**
 * Trait HasUuids
 * @package App\Traits
 * Defines a trait for models that use UUIDs as their primary key.
 */
trait HasUuids
{

  /**
   * Get the value indicating whether the IDs are incrementing.
   *
   * @return bool
   */
  public function getIncrementing()
  {
    return false;
  }

  /**
   * Get the auto-incrementing key type.
   *
   * @return string
   */
  public function getKeyType()
  {
    return 'string';
  }

  public static function boot()
  {
    parent::boot();
    static::creating(function ($model) {
      $model->{$model->getKeyName()} = Str::uuid()->toString();
    });
  }
}
