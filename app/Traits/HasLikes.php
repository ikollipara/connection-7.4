<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        return DB::table($this->getLikeTable())
            ->where($this->getLikeColumn(), $this->id)
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
        return DB::table($this->getLikeTable())
            ->where("user_id", $user->id)
            ->where($this->getLikeColumn(), $this->id)
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
        DB::table($this->getLikeTable())->insert([
            "user_id" => $user->id,
            $this->getLikeColumn() => $this->id,
        ]);

        $this->getLikeEvent()::dispatch($this);
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
        DB::table($this->getLikeTable())
            ->where("user_id", $user->id)
            ->where($this->getLikeColumn(), $this->id)
            ->delete();

        $this->getLikeEvent()::dispatch($this);
    }

    protected function getLikeTable(): string
    {
        return $this->likeTable ??
            Str::of(class_basename(self::class))->snake() . "_likes";
    }
    protected function getLikeColumn(): string
    {
        return $this->likeColumn ??
            Str::of(class_basename(self::class))->snake() . "_id";
    }
    protected function getLikeEvent(): string
    {
        return $this->likeEvent ??
            "\App\Events\\" . class_basename(self::class) . "Liked";
    }
}
