<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait HasViews
{
    public function views()
    {
        return DB::table($this->viewTable)
            ->where($this->viewColumn, $this->id)
            ->count();
    }

    public function isViewedBy($user)
    {
        return DB::table($this->viewTable)
            ->where("user_id", $user->id)
            ->where($this->viewColumn, $this->id)
            ->exists();
    }

    public function view($user)
    {
        DB::table($this->viewTable)->insert([
            "user_id" => $user->id,
            $this->viewColumn => $this->id,
        ]);

        $this->viewEvent::dispatch($this);
    }
}
