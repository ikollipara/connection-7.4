<?php

namespace App\Http\Livewire\Post;

use App\Models\Post;
use App\Notifications\NewFollowedPost;
use App\Traits\Livewire\HasAutosave;
use App\Traits\Livewire\HasDispatch;
use App\Traits\Livewire\HasMetadata;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Editor extends Component
{
    use AuthorizesRequests, HasMetadata, HasAutosave, HasDispatch;

    public Post $post;
    public string $body;
    public bool $ready_to_load_post = false;

    /**
     * @param string|null $uuid
     */
    public function mount($uuid = null): void
    {
        if ($post = Post::find($uuid)) {
            $this->authorize("update", $post);
            $this->post = $post;
            $this->fill([
                "grades" => $post->metadata["grades"],
                "standards" => $post->metadata["standards"],
                "practices" => $post->metadata["practices"],
                "category" => $post->metadata["category"],
                "audience" => $post->metadata["audience"],
                "languages" => $post->metadata["languages"],
            ]);
        } else {
            $this->authorize("create", Post::class);
            $this->post = new Post();
        }
        $this->body = json_encode($this->post->body);
    }

    /** @var array<string, string[]> */
    protected $rules = [
        "body" => ["json"],
        "post.title" => ["string"],
        "post.published" => ["boolean"],
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
        $this->post->user_id = auth()->user()->id;
        $this->post->metadata = $this->getMetadata();
        if (!$this->post->exists) {
            $this->post->body = json_decode($this->body, true);
        }
        if (!$this->post->save()) {
            $this->dispatchBrowserEvent("error", [
                "message" => __("Post not saved!\n{$this->errorBag->all()}"),
            ]);
            return;
        }
        if ($this->post->wasRecentlyPublished()) {
            $message = __("Post published!");
            $this->post->user->notifyFollowers(
                new NewFollowedPost($this->post),
            );
        } else {
            $message = __("Post saved!");
        }
        $this->dispatchBrowserEvent("success", [
            "message" => $message,
        ]);
        $this->dispatchBrowserEventIf(
            $this->post->wasRecentlyCreated,
            "post-created",
            [
                "url" => route("posts.edit", ["uuid" => $this->post->id]),
            ],
        );
        $this->dispatchBrowserEvent("editor-saved");
    }

    /**
     * @return \Illuminate\View\View|\Illuminate\View\Factory
     */
    public function render()
    {
        return view("livewire.post.editor")->layoutData([
            "title" => __("Post Editor"),
        ]);
    }
}
