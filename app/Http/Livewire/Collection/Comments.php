<?php

namespace App\Http\Livewire\Collection;

use App\Models\PostCollection;
use Livewire\Component;
use Livewire\WithPagination;

class Comments extends Component
{
    use WithPagination;

    public PostCollection $collection;
    public string $comment = "";
    public bool $ready_to_load_comments = false;

    public function mount(PostCollection $collection): void
    {
        $this->collection = $collection;
    }

    public function loadComments(): void
    {
        $this->ready_to_load_comments = true;
    }

    public function getCommentsProperty(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        if (!$this->ready_to_load_comments) {
            return new \Illuminate\Pagination\LengthAwarePaginator(
                [],
                0,
                10,
                $this->page,
            );
        }
        return $this->collection
            ->comments()
            ->latest()
            ->paginate(10);
    }

    public function save(): void
    {
        $this->validate([
            "comment" => ["required", "min:1"],
        ]);
        $this->collection->comments()->create([
            "user_id" => auth()->id(),
            "body" => $this->comment,
        ]);
        $this->comment = "";
        $this->resetPage();
    }

    public function render()
    {
        return view("livewire.collection.comments")->layoutData([
            "title" =>
                "conneCTION - " . __($this->collection->title . " - Comments"),
        ]);
    }
}
