<?php

namespace App\Http\Livewire\User;

use App\Models\Post;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Posts extends Component
{
    use WithPagination;

    public User $user;
    public string $search = "";
    public bool $ready_to_load_posts = false;

    public function mount(User $user): void
    {
        $this->user = $user;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function loadPosts(): void
    {
        $this->ready_to_load_posts = true;
    }

    public function getPostsProperty(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        if (!$this->ready_to_load_posts) {
            return new \Illuminate\Pagination\LengthAwarePaginator(
                [],
                0,
                10,
                $this->page,
            );
        }
        return $this->user
            ->posts()
            ->wherePublished()
            ->when($this->search !== "", function ($query) {
                return $query->where("title", "like", "%{$this->search}%");
            })
            ->orderByDesc("likes_count")
            ->orderByDesc("views")
            ->latest()
            ->paginate(10);
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return view("livewire.user.posts")->layoutData([
            "title" =>
                "ConneCTION - " . __("{$this->user->full_name()}'s Posts"),
        ]);
    }
}
