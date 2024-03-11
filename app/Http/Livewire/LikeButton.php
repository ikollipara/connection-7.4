<?php

namespace App\Http\Livewire;

use App\Contracts\Likable;
use Livewire\Component;

class LikeButton extends Component
{
    public Likable $likable;
    public bool $liked = false;
    public bool $ready_to_load_likes = false;

    public function mount(Likable $likable): void
    {
        $this->likable = $likable;
    }

    public function loadLikes(): void
    {
        $this->ready_to_load_likes = true;
    }

    public function getLikesProperty(): int
    {
        if (!$this->ready_to_load_likes) {
            return 0;
        }
        $this->liked = $this->likable->isLikedBy(auth()->user());
        return $this->likable->likes();
    }

    public function toggleLike(): void
    {
        if ($this->liked) {
            $this->unlike();
        } else {
            $this->like();
        }
    }

    public function like(): void
    {
        $this->likable->like(auth()->user());
        $this->liked = true;
        $this->dispatchBrowserEvent("success", [
            "message" => __("Liked!"),
        ]);
    }

    public function unlike(): void
    {
        $this->likable->unlike(auth()->user());
        $this->liked = false;
        $this->dispatchBrowserEvent("success", [
            "message" => __("Unliked!"),
        ]);
    }

    public function render()
    {
        return view("livewire.like-button");
    }
}
