<?php

namespace App\Contracts;


interface HasLikes
{
    public function likes();

    public function isLikedBy($user);

    public function like($user);

    public function unlike($user);
}
