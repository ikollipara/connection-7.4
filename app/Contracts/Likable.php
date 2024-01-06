<?php

/**
 * Likeable contract.
 */

declare(strict_types=1);

namespace App\Contracts;

use App\Models\User;

/**
 * Interface Likable
 * All models that can be liked should implement this interface.
 * This can be done automatically using the `HasLikes` trait.
 * @package App\Contracts
 */
interface Likable
{
    public function likes(): int;

    public function isLikedBy(User $user): bool;

    public function like(User $user): void;

    public function unlike(User $user): void;
}
