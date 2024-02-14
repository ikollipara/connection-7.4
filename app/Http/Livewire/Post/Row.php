<?php

namespace App\Http\Livewire\Post;

use App\Models\Post;
use Livewire\Component;

class Row extends Component
{
    public Post $post;

    public function mount(Post $post): void
    {
        $this->post = $post;
    }

    public function archive(): void
    {
        if ($this->post->delete()) {
            $this->dispatchBrowserEvent("post-removed", [
                "id" => $this->post->id,
            ]);
            $this->dispatchBrowserEvent("success", [
                "message" => __("Post archived successfully!"),
            ]);
        } else {
            $this->dispatchBrowserEvent("error", [
                "message" => __("Post could not be archived!"),
            ]);
        }
    }

    public function restore(): void
    {
        if ($this->post->restore()) {
            $this->dispatchBrowserEvent("post-removed", [
                "id" => $this->post->id,
            ]);
            $this->dispatchBrowserEvent("success", [
                "message" => __("Post restored successfully!"),
            ]);
        } else {
            $this->dispatchBrowserEvent("error", [
                "message" => __("Post could not be restored!"),
            ]);
        }
    }

    public function render()
    {
        return view("livewire.post.row");
    }
}
