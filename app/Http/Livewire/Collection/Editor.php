<?php

namespace App\Http\Livewire\Collection;

use Livewire\Component;
use App\Models\PostCollection;
use App\Notifications\NewFollowedCollection;
use App\Traits\Livewire\HasAutosave;
use App\Traits\Livewire\HasDispatch;
use App\Traits\Livewire\HasMetadata;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Editor extends Component
{
    use AuthorizesRequests, HasMetadata, HasDispatch, HasAutosave;

    public string $body;
    public PostCollection $post_collection;

    /**
     * @param string|null $uuid
     */
    public function mount($uuid = null): void
    {
        if ($post_collection = PostCollection::find($uuid)) {
            $this->authorize("update", $post_collection);
            $this->post_collection = $post_collection;
            $this->fill([
                "grades" => $post_collection->metadata["grades"],
                "standards" => $post_collection->metadata["standards"],
                "practices" => $post_collection->metadata["practices"],
                "category" => $post_collection->metadata["category"],
                "audience" => $post_collection->metadata["audience"],
                "languages" => $post_collection->metadata["languages"],
            ]);
        } else {
            $this->authorize("create", PostCollection::class);
            $this->post_collection = new PostCollection();
        }
        $this->body = json_encode($this->post_collection->body);
    }

    /** @var array<string, string[]> */
    protected $rules = [
        "body" => ["json"],
        "post_collection.title" => ["string"],
        "post_collection.published" => ["boolean"],
        "audience" => ["string"],
        "category" => ["string"],
        "grades" => ["array"],
        "standards" => ["array"],
        "practices" => ["array"],
        "languages" => ["array"],
    ];

    public function save(): void
    {
        $this->validate();
        $this->post_collection->user_id = auth()->user()->id;
        $this->post_collection->metadata = $this->getMetadata();
        if (!$this->post_collection->exists) {
            $this->post_collection->body = json_decode($this->body, true);
        }
        if (!$this->post_collection->save()) {
            $this->dispatchBrowserEvent("error", [
                "message" => __(
                    "Collection not saved!\n{$this->errorBag->all()}",
                ),
            ]);
            return;
        }
        if ($this->post_collection->wasRecentlyPublished()) {
            $message = __("Collection published!");
            $this->post_collection->user->notifyFollowers(
                new NewFollowedCollection($this->post_collection),
            );
        } elseif ($this->post_collection->wasRecentlyCreated) {
            $message = __("Collection created!");
            $this->dispatchBrowserEvent("collection-created", [
                "url" => route("collections.edit", [
                    "uuid" => $this->post_collection->id,
                ]),
            ]);
        } else {
            $message = __("Collection saved!");
        }
        $this->dispatchBrowserEvent("editor-saved");
        $this->dispatchBrowserEvent("success", [
            "message" => $message,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return view("livewire.collection.editor")->layoutData([
            "title" => __("Collection Editor"),
        ]);
    }
}
