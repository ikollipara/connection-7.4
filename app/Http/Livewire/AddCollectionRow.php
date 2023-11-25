<?php

namespace App\Http\Livewire;

use App\Models\Post;
use App\Models\PostCollection;
use Livewire\Component;

class AddCollectionRow extends Component
{
    public PostCollection $collection;
    public Post $post;
    public bool $has_post = false;

    public function mount(PostCollection $collection, Post $post)
    {
        $this->collection = $collection;
        $this->post = $post;
        $this->has_post = $collection->posts->contains($post);
    }

    public function add()
    {
        $this->collection->posts()->attach($this->post);
        $this->has_post = true;
        $this->dispatchBrowserEvent("success", [
            "message" => "Post added to collection successfully!",
        ]);
    }

    public function remove()
    {
        $this->collection->posts()->detach($this->post);
        $this->has_post = false;
        $this->dispatchBrowserEvent("success", [
            "message" => "Post removed from collection successfully!",
        ]);
    }

    public function render()
    {
        return view("livewire.add-collection-row");
    }
}
