<?php

namespace App\Traits;

use App\Models\User;
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
    public function likes(): int
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
    public function isLikedBy(User $user): bool
    {
        return DB::table($this->likeTable)
            ->where("user_id", $user->id)
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
    public function like(User $user): void
    {
        DB::table($this->likeTable)->insert([
            "user_id" => $user->id,
            $this->likeColumn => $this->id,
        ]);

        $this->likeEvent::dispatch($this);
    }

    /**
     * Delete a like for the item.
     * The name of the table is provided by a
     * protected variable named $likeTable and
     * the column name is provided by a protected
     * variable named $likeColumn.
     */
    public function unlike(User $user): void
    {
        DB::table($this->likeTable)
            ->where("user_id", $user->id)
            ->where($this->likeColumn, $this->id)
            ->delete();

        $this->likeEvent::dispatch($this);
    }
}
