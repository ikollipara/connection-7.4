<?php

namespace App\Contracts;

interface Commentable
{
    /**
     * Get all of the comments for the model.
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany<\App\Models\Comment>
     */
    public function comments();
}
