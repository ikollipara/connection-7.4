<?php

namespace App\Http\Livewire;

use App\Contracts\Likable;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Livewire\Component;

class Likes extends Component
{
    public Likable $likable;
    public ?int $likes = null;
    public bool $liked = false;
    public bool $readyToLoad = false;
    public User $user;

    public function mount(Likable $likable): void
    {
        $user = auth()->user();
        if (!$user) {
            return;
        }
        $this->user = $user;
        $this->likable = $likable;
        /** @phpstan-ignore-next-line */
        $this->likes = $this->likable->likes_count;
        $this->liked = $this->likable->isLikedBy($this->user);
    }

    public function like(): void
    {
        $this->likable->like($this->user);
        $this->liked = true;
        $this->likes++;
    }

    public function unlike(): void
    {
        $this->likable->unlike($this->user);
        $this->liked = false;
        $this->likes--;
    }

    /**
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return view("livewire.likes");
    }
}
