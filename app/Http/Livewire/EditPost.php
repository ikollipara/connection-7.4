<?php

namespace App\Http\Livewire;

use App\Enums\Audience;
use App\Enums\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;

class EditPost extends Component
{
    public Post $post;

    /** @var array<string> */
    public array $grades = [];

    /** @var array<string> */
    public array $standards = [];

    /** @var array<string> */
    public array $practices = [];

    public string $category = Category::Material;

    public string $audience = Audience::Students;

    public string $title;

    public string $body;

    public bool $is_published = false;

    public function mount(Post $post): void
    {
        $this->post = $post;
        $this->fill([
            "title" => $post->title,
            "body" => json_encode($post->body),
            "is_published" => $post->published,
            "audience" => $post->metadata["audience"],
            "category" => $post->metadata["category"],
            "grades" => $post->metadata["grades"],
            "standards" => $post->metadata["standards"],
            "practices" => $post->metadata["practices"],
        ]);
    }

    /**
     *  @return array<string, string|array<string>>
     */
    public function rules()
    {
        return [
            "body" => ["json"],
            "audience" => ["string"],
            "category" => ["string"],
            "grades" => ["array"],
            "standards" => ["array"],
            "practices" => ["array"],
        ];
    }

    public function save(): RedirectResponse
    {
        $this->validate();
        $result = $this->post->update([
            "title" => $this->title,
            "body" => json_decode($this->body, true),
            "published" => $this->is_published,
            "metadata" => [
                "audience" => $this->audience,
                "category" => $this->category,
                "grades" => $this->grades,
                "standards" => $this->standards,
                "practices" => $this->practices,
            ],
        ]);

        if ($result) {
            $this->dispatchBrowserEvent("success", [
                "message" => "Successfully Updated!",
            ]);
            $this->dispatchBrowserEvent("editor-saved");
        } else {
            $this->dispatchBrowserEvent("error", [
                "message" => "Something went wrong!",
            ]);
        }

        return back();
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return view("livewire.edit-post");
    }
}
