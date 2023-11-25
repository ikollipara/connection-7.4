<?php

namespace App\Traits;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasComments
{
  /**
   * Get all of the comments for the model.
   * @return \Illuminate\Database\Eloquent\Relations\MorphMany<\App\Models\Comment>
   */
  public function comments(): MorphMany
  {
    return $this->morphMany(Comment::class, 'commentable');
  }
}
