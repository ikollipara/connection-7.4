<?php

namespace App\Models;

use App\Traits\HasUuids;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Passwords\CanResetPassword as PasswordsCanResetTrait;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

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
     * Get the user's full name.
     * @return string The User's full name
     */
    public function full_name()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function avatar_url(): string
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
        // Before creating the user,
        // we hash the password and normalize the email.
        static::creating(function (User $user) {
            $user->email = Str::of($user->email)
                ->trim()
                ->lower();
            $user->password = Hash::make($user->password);
        });
        static::created(function (User $user) {
            event(new Registered($user));
        });
    }
}
