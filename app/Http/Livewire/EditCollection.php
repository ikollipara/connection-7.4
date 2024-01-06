<?php

namespace App\Http\Livewire;

use App\Enums\Audience;
use App\Enums\Category;
use App\Models\PostCollection;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;

class EditCollection extends Component
{
    public PostCollection $collection;

    public bool $published = false;

    public string $title = "";

    public string $body = '{"blocks": [] }';

    /** @var array<string> */
    public array $grades = [];

    /** @var array<string> */
    public array $standards = [];

    /** @var array<string> */
    public array $practices = [];

    public string $category = Category::Material;

    public string $audience = Audience::Students;

    public function mount(PostCollection $collection): void
    {
        $this->fill([
            "title" => $collection->title,
            "body" => json_encode($collection->body),
            "published" => $collection->published,
            "audience" => $collection->metadata["audience"],
            "category" => $collection->metadata["category"],
            "grades" => $collection->metadata["grades"],
            "standards" => $collection->metadata["standards"],
            "practices" => $collection->metadata["practices"],
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function save()
    {
        $this->validate();
        $result = $this->collection->update([
            "published" => $this->published,
            "title" => $this->title,
            "body" => json_decode($this->body, true),
        ]);
        if ($result) {
            $this->dispatchBrowserEvent("success", [
                "message" => "Collection updated successfully!",
            ]);
            $this->dispatchBrowserEvent("editor-saved");
            return back();
        } else {
            $this->dispatchBrowserEvent("error", [
                "message" => "Collection failed to update!",
            ]);
        }
    }

    public function removeEntry(string $post_id): void
    {
        $this->collection->posts()->detach([$post_id]);
        $this->dispatchBrowserEvent("success", [
            "message" => "Post removed from collection successfully!",
        ]);
        $this->emit("postRemoved", $post_id);
    }

    /**
     * @return array<string, string|array<string>>
     */
    public function rules()
    {
        return [
            "title" => "string",
            "body" => "json",
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return view("livewire.edit-collection");
    }
}
