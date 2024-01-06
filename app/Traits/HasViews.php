<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\DB;

trait HasViews
{
    public function views(): int
    {
        return DB::table($this->viewTable)
            ->where($this->viewColumn, $this->id)
            ->count();
    }

    public function isViewedBy(User $user): bool
    {
        return DB::table($this->viewTable)
            ->where("user_id", $user->id)
            ->where($this->viewColumn, $this->id)
            ->exists();
    }

    public function view(User $user): void
    {
        DB::table($this->viewTable)->insert([
            "user_id" => $user->id,
            $this->viewColumn => $this->id,
        ]);

        $this->viewEvent::dispatch($this);
    }
}
