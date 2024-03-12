<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Parental\HasParent;

class ResearchUser extends Model
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
}
