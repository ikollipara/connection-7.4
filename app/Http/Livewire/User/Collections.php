<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Collections extends Component
{
    use WithPagination;

    public User $user;
    public string $search = "";
    public bool $ready_to_load_collections = false;

    public function mount(User $user): void
    {
        $this->user = $user;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function loadCollections(): void
    {
        $this->ready_to_load_collections = true;
    }

    public function getCollectionsProperty(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        if (!$this->ready_to_load_collections) {
            return new \Illuminate\Pagination\LengthAwarePaginator(
                [],
                0,
                10,
                $this->page,
            );
        }
        return $this->user
            ->postCollections()
            ->where("published", true)
            ->when(
                $this->search !== "",
                fn($query) => $query->where(
                    "title",
                    "like",
                    "%{$this->search}%",
                ),
            )
            ->orderBy("likes_count", "desc")
            ->orderBy("views", "desc")
            ->latest()
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
