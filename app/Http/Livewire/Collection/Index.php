<?php

namespace App\Http\Livewire\Collection;

use Livewire\Component;
use App\Models\PostCollection;
use Illuminate\Support\Collection;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $status = "draft";
    public User $user;
    public string $search = "";
    public bool $ready_to_load_collections = false;

    public function mount(): void
    {
        $this->status = request()->query("status", "draft");
    }

    /** @return array<string, string[]|string> */
    public function rules(): array
    {
        return [
            "search" => ["string", "nullable"],
        ];
    }

    public function updatingSearch(string $value): void
    {
        $this->resetPage();
    }

    public function loadCollections(): void
    {
        $this->ready_to_load_collections = true;
    }

    public function getPostCollectionsProperty(): LengthAwarePaginator
    {
        if (!$this->ready_to_load_collections) {
            return new \Illuminate\Pagination\LengthAwarePaginator(
                [],
                0,
                10,
                $this->page,
            );
        }
        return auth()
            ->user()
            ->postCollections()
            ->status($this->status)
            ->when(
                $this->search !== "",
                fn($query) => $query->where(
                    "title",
                    "like",
                    "%{$this->search}%",
                ),
            )
            ->latest()
            ->paginate(10);
    }

    /** @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory */
    public function render()
    {
        $status = Str::title($this->status);
        return view("livewire.collection.index")->layoutData([
            "title" => "ConneCTION " . __("{$status} Collections"),
        ]);
    }
}
