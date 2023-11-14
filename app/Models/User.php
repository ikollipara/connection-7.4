<?php

namespace App\Models;

use App\Traits\HasUuids;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'avatar',
        'school',
        'subject',
        'gender',
        'bio',
        'grades',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'bio' => 'array',
        'grades' => 'array',
        'id' => 'string',
    ];

    /**
     * Get the user's posts
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the user's full name.
     * @return string The User's full name
     */
    public function full_name()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public static function booted()
    {
        // Before creating the user,
        // we hash the password and normalize the email.
        static::creating(function (User $user) {
            $user->email = Str::of($user->email)->trim()->lower();
            $user->password = Hash::make($user->password);
        });
    }
}
