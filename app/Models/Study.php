<?php

namespace App\Models;

use App\Notifications\NotifyResearchParticipants;
use App\Traits\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Study
 *
 * @property string $id
 * @property string $title
 * @property array<string, mixed> $consent_form
 * @property-read bool $is_active
 * @property bool $irb_approved
 * @property array<string, mixed> $user_filters
 * @property \Illuminate\Support\Carbon|null $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ResearchUser|null $user
 */
class Study extends Model
{
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillables = ["title", "consent_form", "start_date", "end_date"];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, mixed>
     */
    protected $casts = [
        "consent_form" => "array",
        "start_date" => "date",
        "end_date" => "date",
        "is_active" => "boolean",
        "irb_approved" => "boolean",
        "user_filters" => "array",
    ];

    protected $attributes = [
        "consent_form" => '{"blocks": []}',
        "user_filters" =>
            '{"grades": [], "years_of_experience": 0, "includes": "all"}',
    ];

    /**
     * Get the user that owns the study.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<ResearchUser, self>
     */
    public function user()
    {
        // @phpstan-ignore-next-line
        return $this->belongsTo(ResearchUser::class, "user_id", "id", "users");
    }

    /**
     * The participants that belong to the study.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<User>
     */
    public function participants()
    {
        return $this->belongsToMany(User::class, "particpants");
    }

    /**
     * Scope a query to only include active studies.
     * @param \Illuminate\Database\Eloquent\Builder<self> $query
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopeActive($query)
    {
        return $query->where("is_active", true);
    }

    public function notifyParticipants(string $message): void
    {
        $this->participants()->each(function (User $participant) use (
            $message
        ) {
            $participant->notify(
                new NotifyResearchParticipants($this, $message),
            );
        });
    }

    public function allowedToParticipate(User $user): bool
    {
        $allowed = false;
        if (
            $this->user_filters["grades"] === [] or
            array_intersect($this->user_filters["grades"], $user->grades) !== []
        ) {
            if (
                $this->user_filters["years_of_experience"] <=
                $user->years_of_experience
            ) {
                if ($this->user_filters["includes"] === "all") {
                    $allowed = true;
                } elseif (
                    $this->user_filters["includes"] === "preservice" and
                    $user->is_preservice
                ) {
                    $allowed = true;
                } elseif (
                    $this->user_filters["includes"] === "inservice" and
                    !$user->is_preservice
                ) {
                    $allowed = true;
                }
            }
        }
        return $allowed;
    }
}
