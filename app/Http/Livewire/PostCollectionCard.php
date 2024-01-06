<?php

namespace App\Http\Livewire;

use App\Models\PostCollection;
use Livewire\Component;

class PostCollectionCard extends Component
{
    public PostCollection $collection;

    public function archive(): void
    {
        if ($this->collection->delete()) {
            $this->emit("collectionArchived", $this->collection->id);
            $this->dispatchBrowserEvent("success", [
                "message" => "Collection archived successfully!",
            ]);
        } else {
            $this->dispatchBrowserEvent("error", [
                "message" => "Collection could not be archived!",
            ]);
        }
    }

    public function restore(): void
    {
        if ($this->collection->restore()) {
            $this->emit("collectionRestored", $this->collection->id);
            $this->dispatchBrowserEvent("success", [
                "message" => "Collection restored successfully!",
            ]);
        } else {
            $this->dispatchBrowserEvent("error", [
                "message" => "Collection could not be restored!",
            ]);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return view("livewire.post-collection-card");
    }
}
