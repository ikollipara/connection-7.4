<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class PostCard extends Component
{
    public Post $post;

    public function archive(): void
    {
        if ($this->post->delete()) {
            $this->emit("postArchived", $this->post->id);
            $this->dispatchBrowserEvent("success", [
                "message" => "Post archived successfully!",
            ]);
        } else {
            $this->dispatchBrowserEvent("error", [
                "message" => "Post could not be archived!",
            ]);
        }
    }

    public function restore(): void
    {
        if ($this->post->restore()) {
            $this->emit("postRestored", $this->post->id);
            $this->dispatchBrowserEvent("success", [
                "message" => "Post restored successfully!",
            ]);
        } else {
            $this->dispatchBrowserEvent("error", [
                "message" => "Post could not be restored!",
            ]);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return view("livewire.post-card");
    }
}
