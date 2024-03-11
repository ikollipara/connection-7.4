<?php

namespace App\Http\Livewire\Post;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class Comments extends Component
{
    use WithPagination;

    public Post $post;
    public string $comment = "";
    public bool $ready_to_load_comments = false;

    public function mount(Post $post): void
    {
        $this->post = $post;
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
        return $this->post
            ->comments()
            ->latest()
            ->paginate(10);
    }

    public function save(): void
    {
        $this->validate([
            "comment" => ["required", "min:1"],
        ]);
        $this->post->comments()->create([
            "user_id" => auth()->id(),
            "body" => $this->comment,
        ]);
        $this->comment = "";
        $this->resetPage();
    }

    public function render()
    {
        return view("livewire.post.comments")->layoutData([
            "title" => "conneCTION - " . __($this->post->title . " - Comments"),
        ]);
    }
}
