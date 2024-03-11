<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait HasViews
{
    public function views(): int
    {
        return DB::table($this->getViewTable())
            ->where($this->getViewColumn(), $this->id)
            ->count();
    }

    public function isViewedBy(User $user): bool
    {
        return DB::table($this->getViewTable())
            ->where("user_id", "=", $user->id)
            ->where($this->getViewColumn(), "=", $this->id)
            ->exists();
    }

    public function view(User $user): void
    {
        DB::table($this->getViewTable())->insert([
            "user_id" => $user->id,
            $this->getViewColumn() => $this->id,
        ]);

        $this->getViewEvent()::dispatch($this);
    }

    protected function getViewTable(): string
    {
        return $this->viewTable ??
            Str::of(class_basename(self::class))->snake() . "_views";
    }

    protected function getViewColumn(): string
    {
        return $this->viewColumn ??
            Str::of(class_basename(self::class))->snake() . "_id";
    }

    protected function getViewEvent(): string
    {
        return $this->viewEvent ??
            "\App\Events\\" . class_basename(self::class) . "Viewed";
    }
}
