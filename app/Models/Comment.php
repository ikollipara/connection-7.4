<?php

namespace App\Models;

use App\Traits\HasUuids;
use App\Contracts\Likable;
use App\Events\CommentLiked;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLikes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model implements Likable
{
    use HasFactory, HasUuids, HasLikes;

    protected string $likeTable = "comment_likes";
    protected string $likeColumn = "comment_id";
    /** @var class-string */
    protected string $likeEvent = CommentLiked::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ["body", "user_id"];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    /**
     * Get the user that owns the comment.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, self>
     */
    public function user()
    {
        /** @phpstan-ignore-next-line */
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post or post collection that owns the comment.
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo<\App\Models\Post|\App\Models\PostCollection, self>
     */
    public function commentable()
    {
        return $this->morphTo();
    }
}
