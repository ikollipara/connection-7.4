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
 * @property string $id
 * @property string $title
 * @property array<string, string> $body
 * @property array<string, string|string[]> $metadata
 * @property bool $published
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection<\App\Models\Comment> $comments
 * @property-read \Illuminate\Database\Eloquent\Collection<\App\Models\Post> $posts
 */
class PostCollection extends Model implements Likable, Viewable, Commentable
{
    use HasFactory,
        HasUuids,
        SoftDeletes,
        HasComments,
        HasViews,
        HasLikes,
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
        "title" => "string",
    ];

    /**
     * The attributes that should be defaults.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        "metadata" => '{"category": "material", "audience": "Teachers"}',
        "body" => '{"blocks": []}',
        "published" => false,
        "title" => "",
    ];

    /**
     * Get the user that owns the post collection.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, self>
     */
    public function user()
    {
        /** @phpstan-ignore-next-line */
        return $this->belongsTo(User::class);
    }

    /**
     * Get all the posts for the post collection.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\App\Models\Post>
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    /**
     * Get all the post collections for the given status.
     * @param \Illuminate\Database\Eloquent\Builder<self> $query
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Builder
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
     * Get all the published post collections.
     * @param \Illuminate\Database\Eloquent\Builder<self> $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWherePublished($query)
    {
        return $query->where("published", true);
    }

    /**
     * Convert Post to Searchable Array
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
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
            "user" => $this->user ? $this->user->full_name() : "[Deleted]",
            "likes" => (int) $this->likes_count,
            "views" => (int) $this->views,
        ];
    }

    public function searchableAs(): string
    {
        return "post_collections_index";
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

        static::retrieved(function (PostCollection $postCollection) {
            if (!array_key_exists("languages", $postCollection->metadata)) {
                $postCollection->metadata = array_merge(
                    $postCollection->metadata,
                    [
                        "languages" => [],
                    ],
                );
            }
        });
    }
}
