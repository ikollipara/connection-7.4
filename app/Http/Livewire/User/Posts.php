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

    public function mount(User $user): void
    {
        $this->user = $user;
    }

    public function getPostsProperty(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Post::query()
            ->where("user_id", $this->user->id)
            ->orderByDesc("likes_count")
            ->orderByDesc("views")
            ->orderBy("created_at")
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
