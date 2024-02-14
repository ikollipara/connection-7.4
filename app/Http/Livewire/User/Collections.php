<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Collections extends Component
{
    use WithPagination;

    public User $user;

    public function mount(User $user): void
    {
        $this->user = $user;
    }

    public function getCollectionsProperty(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->user
            ->postCollections()
            ->where("published", true)
            ->orderBy("likes_count", "desc")
            ->orderBy("views", "desc")
            ->orderBy("created_at", "desc")
            ->paginate(10);
    }

    public function render()
    {
        return view("livewire.user.collections")->layoutData([
            "title" =>
                "ConneCTION - " .
                __("{$this->user->full_name()}'s Collections"),
        ]);
    }
}
