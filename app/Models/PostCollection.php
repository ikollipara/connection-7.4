<?php

namespace App\Models;

use App\Contracts\HasLikes;
use App\Traits\HasComments;
use App\Traits\HasLikes as HasLikesTrait;
use App\Traits\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Events\PostCollectionLiked;
use Illuminate\Support\Arr;
use Laravel\Scout\Searchable;

class PostCollection extends Model implements HasLikes
{
    use HasFactory,
        HasUuids,
        SoftDeletes,
        HasComments,
        HasLikesTrait,
        Searchable;

    protected $likeTable = "post_collection_likes";
    protected $likeColumn = "post_collection_id";
    protected $event = PostCollectionLiked::class;

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
     * Get the user that owns the post collection.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all the posts for the post collection.
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    /**
     * Get all the post collections for the given status.
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
        static::creating(function (PostCollection $postCollection) {
            $postCollection->slug = Str::slug(
                "{$postCollection->title} {$postCollection->id} Collection",
            );
        });

        static::updating(function (PostCollection $postCollection) {
            if (!$postCollection->published) {
                $postCollection->slug = Str::slug(
                    "{$postCollection->title} {$postCollection->id} Collection",
                );
            }
        });
    }
}