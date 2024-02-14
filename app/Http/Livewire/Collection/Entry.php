<?php

namespace App\Http\Livewire\Collection;

use App\Models\Post;
use App\Models\PostCollection;
use Livewire\Component;

class Entry extends Component
{
    public Post $post;
    public PostCollection $post_collection;

    public function mount(Post $post, PostCollection $post_collection): void
    {
        $this->post = $post;
        $this->post_collection = $post_collection;
    }

    public function remove(): void
    {
        $this->post_collection->posts()->detach([$this->post->id]);
        $this->dispatchBrowserEvent("success", [
            "message" => __("Removed from collection!"),
        ]);
        $this->dispatchBrowserEvent("entry-removed", ["id" => $this->post->id]);
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return view("livewire.collection.entry");
    }
}
