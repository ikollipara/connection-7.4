<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Parental\HasParent;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection<\App\Models\Study> $studies
 */
class ResearchUser extends User
{
    use HasParent;

    /**
     * The default attributes for the model.
     * @var array<string, mixed>
     */
    protected $attributes = [
        "password" => "",
        "gender" => "",
        "last_name" => "Research Group",
        "bio" => '{"blocks": []}',
        "subject" => "",
    ];

    /**
     * The studies that belong to the research user.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Study>
     */
    public function studies()
    {
        return $this->hasMany(Study::class, "user_id", "id");
    }
}
