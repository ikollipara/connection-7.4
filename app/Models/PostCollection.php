<?php

namespace App\Models;

use App\Traits\HasComments;
use App\Traits\HasLikes;
use App\Traits\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PostCollection extends Model
{
    use HasFactory, HasUuids, SoftDeletes, HasComments, HasLikes;

    protected $likeTable = 'post_collection_likes';
    protected $likeColumn = 'post_collection_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'body',
        'metadata',
        'published',
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'body' => 'array',
        'metadata' => 'array',
        'published' => 'boolean',
    ];

    /**
     * The attributes that should be defaults.
     *
     * @var array<string, string>
     */
    protected $attributes = [
        'metadata' => '{"category": "material", "audience": "Teachers"}',
        'body' => '{"blocks": []}'
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
        if ($status == 'archived') {
            return $query->onlyTrashed();
        } elseif ($status == 'published') {
            return $query->where('published', true);
        } elseif ($status == 'draft') {
            return $query->where('published', false);
        } else {
            return $query;
        }
    }

    public static function booted()
    {
        static::creating(function (PostCollection $postCollection) {
            $postCollection->slug = Str::slug($postCollection->title);
        });

        static::updating(function (PostCollection $postCollection) {
            if (!$postCollection->published) {
                $postCollection->slug = Str::slug($postCollection->title);
            }
        });
    }
}
