<?php

namespace App\Http\Livewire;

use App\Contracts\HasLikes;
use Livewire\Component;

class Likes extends Component
{

    public HasLikes $likable;
    public ?int $likes = null;
    public bool $liked = false;
    public bool $readyToLoad = false;

    public function mount($likable)
    {
        $this->likable = $likable;
        $this->likes = $this->likable->likes_count;
        $this->liked = $this->likable->isLikedBy(auth()->user());
    }



    public function like()
    {
        $this->likable->like(auth()->user());
        $this->liked = true;
        $this->likes++;
    }

    public function unlike()
    {
        $this->likable->unlike(auth()->user());
        $this->liked = false;
        $this->likes--;
    }

    public function render()
    {
        return view('livewire.likes');
    }
}
