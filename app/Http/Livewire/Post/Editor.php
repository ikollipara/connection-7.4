<?php

namespace App\Http\Livewire\Post;

use App\Enums\Audience;
use App\Enums\Category;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewFollowedPost;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Editor extends Component
{
    use AuthorizesRequests;

    public Post $post;
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
    public string $body;

    /**
     * @param string|null $uuid
     */
    public function mount($uuid = null): void
    {
        if ($post = Post::find($uuid)) {
            $this->post = $post;
            if (!array_key_exists("languages", $post->metadata)) {
                $post->metadata = array_merge($post->metadata, [
                    "languages" => [],
                ]);
            }
            $this->authorize("update", $post);
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

    public function updatedBody(string $value): void
    {
        if ($decoded = json_decode($value, true)) {
            // @phpstan-ignore-next-line
            $this->post->body = $decoded;
            if ($this->post->exists) {
                $this->post->save();
                $this->dispatchBrowserEvent("editor-saved");
            }
        }
    }

    public function updatedPostTitle(string $value): void
    {
        $this->post->title = $value;
        if ($this->post->exists) {
            $this->post->save();
            $this->dispatchBrowserEvent("editor-saved");
        }
    }

    public function save(): void
    {
        $this->validate();
        $this->post->user_id = auth()->user()->id;
        $this->post->metadata = [
            "audience" => $this->audience,
            "category" => $this->category,
            "grades" => $this->grades,
            "standards" => $this->standards,
            "practices" => $this->practices,
            "languages" => $this->languages,
        ];
        if (!$this->post->exists) {
            $this->post->body = json_decode($this->body, true);
        }
        if ($this->post->save()) {
            if (
                $this->post->published and $this->post->wasChanged("published")
            ) {
                $this->dispatchBrowserEvent("success", [
                    "message" => __("Post published!"),
                ]);
                $this->post->user->followers->each(function (User $follower) {
                    $follower->notify(new NewFollowedPost($this->post));
                });
            } else {
                $this->dispatchBrowserEvent("success", [
                    "message" => __("Post saved!"),
                ]);
            }
            if ($this->post->wasRecentlyCreated) {
                $this->dispatchBrowserEvent("post-created", [
                    "url" => route("posts.edit", ["uuid" => $this->post->id]),
                ]);
            }
            $this->dispatchBrowserEvent("editor-saved");
        } else {
            $this->dispatchBrowserEvent("error", [
                "message" => __("Post not saved!\n{$this->errorBag->all()}"),
            ]);
        }
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
