<?php

namespace App\Models;

use App\Contracts\HasLikes;
use App\Contracts\Viewable;
use App\Traits\HasComments;
use App\Traits\HasLikes as HasLikesTrait;
use App\Traits\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Events\PostLiked;
use App\Traits\HasViews;
use Laravel\Scout\Searchable;

class Post extends Model implements HasLikes, Viewable
{
    use HasFactory,
        HasUuids,
        SoftDeletes,
        HasComments,
        HasLikesTrait,
        HasViews,
        Searchable;

    protected $viewTable = "post_views";
    protected $viewColumn = "post_id";
    protected $viewEvent = PostViewed::class;
    protected $likeTable = "post_likes";
    protected $likeColumn = "post_id";
    protected $likeEvent = PostLiked::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ["title", "body", "metadata", "published", "user_id"];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "body" => "array",
        "metadata" => "array",
        "published" => "boolean",
        "id" => "string",
    ];

    /**
     * The attributes that should be defaults.
     *
     * @var array<string, string>
     */
    protected $attributes = [
        "metadata" => '{"category": "material", "audience": "Teachers"}',
        "body" => '{"blocks": []}',
    ];

    /**
     * Get the user that owns the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all the posts for the given status.
     */
    public function scopeStatus($query, $status)
    {
        if ($status == "archived") {
            return $query->onlyTrashed();
        } elseif ($status == "published") {
            return $query->where("published", true);
        } elseif ($status == "draft") {
            return $query->where("published", false);
        } else {
            return $query;
        }
    }

    public function toSearchableArray()
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "category" => $this->metadata["category"],
            "audience" => $this->metadata["audience"],
            "grades" => collect($this->metadata["grades"])->join(","),
            "standards" => collect($this->metadata["standards"])->join(","),
            "practices" => collect($this->metadata["practices"])->join(","),
            "user" => $this->user ? $this->user->full_name() : "[Deleted]",
            "likes" => (int) $this->likes_count,
            "views" => (int) $this->views,
        ];
    }

    /**
     * Determine if the model should be searchable.
     *
     * @return bool
     */
    public function shouldBeSearchable()
    {
        return $this->published and !$this->trashed();
    }

    public static function booted()
    {
        static::creating(function (Post $post) {
            $post->slug = Str::slug("{$post->title} {$post->id} Post");
        });

        static::updating(function (Post $post) {
            if (!$post->published) {
                $post->slug = Str::slug("{$post->title} {$post->id} Post");
            }
        });
    }
}
