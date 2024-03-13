<?php

namespace App\Models;

use App\Contracts\Commentable;
use App\Contracts\Likable;
use App\Contracts\Viewable;
use App\Services\BodyExtractor;
use App\Traits\HasComments;
use App\Traits\HasLikes;
use App\Traits\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Traits\HasViews;
use Laravel\Scout\Searchable;

/**
 * App\Models\Post
 * @property string $id
 * @property string $title
 * @property array<string, string> $body
 * @property array<string, string|string[]> $metadata
 * @property bool $published
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<\App\Models\Comment> $comments
 */
class Post extends Model implements Likable, Viewable, Commentable
{
    use HasFactory,
        HasUuids,
        SoftDeletes,
        HasComments,
        HasLikes,
        HasViews,
        Searchable;

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
        "title" => "string",
    ];

    /**
     * The attributes that should be defaults.
     *
     * @var array<string, string>
     */
    protected $attributes = [
        "metadata" => '{"category": "material", "audience": "Teachers"}',
        "body" => '{"blocks": []}',
        "title" => "",
        "published" => false,
    ];

    /**
     * Get the user that owns the post.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, self>
     */
    public function user()
    {
        /** @phpstan-ignore-next-line */
        return $this->belongsTo(User::class);
    }

    /**
     * Get all the posts for the given status.
     * @param \Illuminate\Database\Eloquent\Builder<self> $query
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Builder<self>
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

    /**
     * Get all the published posts.
     * @param \Illuminate\Database\Eloquent\Builder<self> $query
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopeWherePublished($query)
    {
        return $query->where("published", true);
    }

    /**
     * Convert PostCollection to Searchable Array
     * @return array<string, mixed>
     */
    public function toSearchableArray()
    {
        if (!array_key_exists("languages", $this->metadata)) {
            $this->metadata = array_merge($this->metadata, ["languages" => []]);
        }
        return [
            "id" => $this->id,
            "title" => $this->title,
            "body" => BodyExtractor::extract($this->body),
            "category" => $this->metadata["category"],
            "audience" => $this->metadata["audience"],
            "grades" => collect($this->metadata["grades"])->join(","),
            "standards" => collect($this->metadata["standards"])->join(","),
            "practices" => collect($this->metadata["practices"])->join(","),
            "languages" => collect($this->metadata["languages"])->join(","),
            "user" => $this->user->exists()
                ? $this->user->full_name()
                : "[Deleted]",
            "likes" => (int) $this->likes_count,
            "views" => (int) $this->views,
        ];
    }

    public function searchableAs(): string
    {
        return "posts_index";
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

    public function wasRecentlyPublished(): bool
    {
        return $this->published and $this->wasChanged("published");
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

        static::retrieved(function (Post $post) {
            if (!array_key_exists("languages", $post->metadata)) {
                $post->metadata = array_merge($post->metadata, [
                    "languages" => [],
                ]);
            }
        });
    }
}
