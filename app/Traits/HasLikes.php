<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

/**
 * Trait HasLikes
 * @package App\Traits
 * Enables a model to be liked by a user.
 * Contains two variables: $likeTable and $likeColumn.
 */
trait HasLikes
{

  /**
   * Get the total number of likes for the item.
   */
  public function likes()
  {
    return DB::table($this->likeTable)
      ->where($this->likeColumn, $this->id)
      ->count();
  }

  /**
   * Check if the user has liked the item.
   * The name of the table is provided by a
   * protected variable named $likeTable and
   * the column name is provided by a protected
   * variable named $likeColumn.
   */
  public function isLikedBy($user)
  {
    return DB::table($this->likeTable)
      ->where('user_id', $user->id)
      ->where($this->likeColumn, $this->id)
      ->exists();
  }

  /**
   * Create a new like for the item.
   * The name of the table is provided by a
   * protected variable named $likeTable and
   * the column name is provided by a protected
   * variable named $likeColumn.
   */
  public function like($user)
  {
    DB::table($this->likeTable)->insert([
      'user_id' => $user->id,
      $this->likeColumn => $this->id,
    ]);
  }

  /**
   * Delete a like for the item.
   * The name of the table is provided by a
   * protected variable named $likeTable and
   * the column name is provided by a protected
   * variable named $likeColumn.
   */
  public function unlike($user)
  {
    DB::table($this->likeTable)
      ->where('user_id', $user->id)
      ->where($this->likeColumn, $this->id)
      ->delete();
  }
}
