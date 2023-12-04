<?php

namespace App\Models;

use App\Traits\HasUuids;
use App\Contracts\HasLikes;
use App\Events\CommentLiked;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasLikes as HasLikesTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model implements HasLikes
{
    use HasFactory, HasUuids, HasLikesTrait;

    protected $likeTable = "comment_likes";
    protected $likeColumn = "comment_id";
    protected $likeEvent = CommentLiked::class;

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
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post or post collection that owns the comment.
     */
    public function commentable()
    {
        return $this->morphTo();
    }
}
