<?php

namespace App\Http\Livewire\Collection;

use Livewire\Component;
use App\Enums\Audience;
use App\Enums\Category;
use App\Models\PostCollection;
use App\Models\User;
use App\Notifications\NewFollowedCollection;

class Editor extends Component
{
    public string $body;
    /** @var string[] */
    public array $grades = [];
    /** @var string[] */
    public array $standards = [];
    /** @var string[] */
    public array $practices = [];
    /** @var string[] */
    public array $languages = [];

    public string $category = Category::Material;
    public string $audience = Audience::Students;

    public PostCollection $post_collection;

    /**
     * @param string|null $uuid
     */
    public function mount($uuid = null)
    {
        if ($post_collection = PostCollection::find($uuid)) {
            $this->post_collection = $post_collection;
            if (!array_key_exists("languages", $post_collection->metadata)) {
                $post_collection->metadata = array_merge(
                    $post_collection->metadata,
                    [
                        "languages" => [],
                    ],
                );
            }
            $this->fill([
                "grades" => $post_collection->metadata["grades"],
                "standards" => $post_collection->metadata["standards"],
                "practices" => $post_collection->metadata["practices"],
                "category" => $post_collection->metadata["category"],
                "audience" => $post_collection->metadata["audience"],
                "languages" => $post_collection->metadata["languages"],
            ]);
        } else {
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

    public function updatedBody(string $value): void
    {
        // @phpstan-ignore-next-line
        $this->post_collection->body = json_decode($value, true);
        if ($this->post_collection->exists) {
            $this->post_collection->save();
            $this->dispatchBrowserEvent("editor-saved");
        }
    }

    public function save(): void
    {
        $this->validate();
        $this->post_collection->user_id = auth()->user()->id;
        $this->post_collection->metadata = [
            "audience" => $this->audience,
            "category" => $this->category,
            "grades" => $this->grades,
            "standards" => $this->standards,
            "practices" => $this->practices,
            "languages" => $this->languages,
        ];
        if ($this->post_collection->save()) {
            if (
                $this->post_collection->published and
                $this->post_collection->wasChanged("published")
            ) {
                $this->dispatchBrowserEvent("success", [
                    "message" => __("Collection published successfully!"),
                ]);
                $this->post_collection->user->followers->each(function (
                    User $follower
                ) {
                    $follower->notify(
                        new NewFollowedCollection($this->post_collection),
                    );
                });
            } elseif ($this->post_collection->wasRecentlyCreated) {
                $this->dispatchBrowserEvent("success", [
                    "message" => __("Collection created successfully!"),
                ]);
            } else {
                $this->dispatchBrowserEvent("success", [
                    "message" => __("Collection saved successfully!"),
                ]);
            }
            if ($this->post_collection->wasRecentlyCreated) {
                $this->dispatchBrowserEvent("collection-created", [
                    "url" => route("collections.edit", [
                        "uuid" => $this->post_collection->id,
                    ]),
                ]);
            }
            $this->dispatchBrowserEvent("editor-saved");
        } else {
            $this->dispatchBrowserEvent("error", [
                "message" => __("Collection could not be saved."),
            ]);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return view("livewire.collection.editor")->layoutData([
            "title" => __("Create Collection"),
        ]);
    }
}
