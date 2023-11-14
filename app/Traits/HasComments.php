<?php

namespace App\Traits;

use App\Models\Comment;

trait HasComments
{
  /**
   * Get all of the comments for the model.
   */
  public function comments()
  {
    return $this->morphMany(Comment::class, 'commentable');
  }
}
