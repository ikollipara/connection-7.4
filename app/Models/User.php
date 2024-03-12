<?php

namespace App\Models;

use App\Casts\Hashed;
use App\Events\UserFollowed;
use App\Traits\HasUuids;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Passwords\CanResetPassword as PasswordsCanResetTrait;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Parental\HasChildren;

/**
 * App\Models\User
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property string $avatar
 * @property string $school
 * @property string $subject
 * @property string $gender
 * @property array<string, string> $bio
 * @property array<string> $grades
 * @property string $email
 * @property bool $no_comment_notifications
 * @property bool $consented
 * @property bool $is_preservice
 * @property int $years_of_experience
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<\App\Models\Comment> $comments
 * @property-read \Illuminate\Database\Eloquent\Collection<\App\Models\PostCollection> $postCollections
 * @property-read \Illuminate\Database\Eloquent\Collection<\App\Models\Post> $posts
 * @property-read \Illuminate\Database\Eloquent\Collection<\App\Models\User> $followers
 * @property-read \Illuminate\Database\Eloquent\Collection<\App\Models\User> $following
 */
class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids, PasswordsCanResetTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "first_name",
        "last_name",
        "avatar",
        "school",
        "subject",
        "gender",
        "bio",
        "grades",
        "email",
        "password",
        "no_comment_notifications",
        "years_of_experience",
        "is_preservice",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ["password", "remember_token"];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "email_verified_at" => "datetime",
        "bio" => "array",
        "grades" => "array",
        "no_comment_notifications" => "boolean",
        "password" => Hashed::class,
    ];

    /** @var array<string, mixed> */
    protected $attributes = [
        "password" => "",
        "gender" => "",
        "is_preservice" => false,
        "school" => "",
        "bio" => '{"blocks": []}',
        "years_of_experience" => 0,
    ];

    /**
     * Get the user's posts
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Post>
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the user's post collections
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\PostCollection>
     */
    public function postCollections()
    {
        return $this->hasMany(PostCollection::class);
    }

    /**
     * Get the user's comments
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Comment>
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the user's followers
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\App\Models\User>
     */
    public function followers()
    {
        return $this->belongsToMany(
            User::class,
            "followers",
            "user_id",
            "follower_id",
        );
    }

    /**
     * Get the user's following
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\App\Models\User>
     */
    public function following()
    {
        return $this->belongsToMany(
            User::class,
            "followers",
            "follower_id",
            "user_id",
        );
    }

    /**
     * Check if the user is following another user
     * @param User $user The user to check
     * @return bool
     */
    public function follow(User $user)
    {
        $this->following()->attach($user->id);
        if ($this->save()) {
            UserFollowed::dispatch($this, $user);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Unfollow a user
     * @param User $user The user to unfollow
     * @return bool
     */
    public function unfollow(User $user)
    {
        $this->following()->detach($user->id);
        if ($this->save()) {
            UserFollowed::dispatch($this, $user);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if the user is following another user
     * @param User $user The user to check
     * @return bool
     */
    public function hasFollowed(User $user): bool
    {
        return $this->following()
            ->where("user_id", $user->id)
            ->exists();
    }

    public function notifyFollowers(object $notification): void
    {
        $this->followers()->each(
            fn(User $follower) => $follower->notify($notification),
        );
    }

    /**
     * Get the user's full name.
     * @return string The User's full name
     */
    public function full_name()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function avatar(): string
    {
        /**
         * If the user doesn't have an avatar,
         * we generate one using the user's full name
         * using the ui-avatars.com API.
         */
        if (!$this->avatar) {
            $full_name = Str::of($this->full_name())
                ->trim()
                ->replace(" ", "+");
            return "https://ui-avatars.com/api/?name={$full_name}&color=7F9CF5&background=EBF4FF";
        }
        return Storage::url($this->avatar);
    }

    public static function booted()
    {
        // Before creating the user, we normalize the email.
        static::creating(function (User $user) {
            $user->email = Str::of($user->email)
                ->trim()
                ->lower();
        });
        static::created(function (User $user) {
            event(new Registered($user));
        });
    }

    /**
     * Scope a query to only include preservice users.
     * @param \Illuminate\Database\Eloquent\Builder<self> $query
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopePreservice($query)
    {
        return $query->where("is_preservice", true);
    }
}
