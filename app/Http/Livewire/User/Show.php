<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;

class Show extends Component
{
    public User $user;
    public string $bio;
    public bool $ready_to_load_collections = false;
    public bool $ready_to_load_posts = false;

    public function mount(User $user): void
    {
        $this->user = $user;
        $this->bio = json_encode($user->bio);
    }

    public function loadCollections(): void
    {
        $this->ready_to_load_collections = true;
    }

    public function loadPosts(): void
    {
        $this->ready_to_load_posts = true;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<\App\Models\Post>
     */
    public function getTopPostsProperty()
    {
        if (!$this->ready_to_load_posts) {
            return collect();
        }
        return $this->user
            ->posts()
            ->wherePublished()
            ->orderByDesc("likes_count")
            ->orderByDesc("views")
            ->limit(10)
            ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<\App\Models\PostCollection>
     */
    public function getTopCollectionsProperty()
    {
        if (!$this->ready_to_load_collections) {
            return collect();
        }
        return $this->user
            ->postCollections()
            ->wherePublished()
            ->orderByDesc("likes_count")
            ->orderByDesc("views")
            ->limit(10)
            ->get();
    }

    public function follow(User $user): void
    {
        if ($user->follow($this->user)) {
            $this->dispatchBrowserEvent("success", [
                "message" => __("Followed!"),
            ]);
        } else {
            $this->dispatchBrowserEvent("error", [
                "message" => __("Failed to follow!"),
            ]);
        }
    }

    public function unfollow(User $user): void
    {
        if ($user->unfollow($this->user)) {
            $this->dispatchBrowserEvent("success", [
                "message" => __("Unfollowed!"),
            ]);
        } else {
            $this->dispatchBrowserEvent("error", [
                "message" => __("Failed to unfollow!"),
            ]);
        }
    }

    /** @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory */
    public function render()
    {
        return view("livewire.user.show");
    }
}
