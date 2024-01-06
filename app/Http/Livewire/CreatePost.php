<?php

namespace App\Http\Livewire;

use App\Enums\Audience;
use App\Enums\Category;
use App\Models\Post;
use Livewire\Component;

class CreatePost extends Component
{
    public string $title = "";

    public string $body = '{"blocks": []}';

    public bool $is_published = false;

    /** @var array<string> */
    public array $grades = [];

    /** @var array<string> */
    public array $standards = [];

    /** @var array<string> */
    public array $practices = [];

    public string $category = Category::Material;

    public string $audience = Audience::Students;

    /**
     * @return array<string, string|array<string>>
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

    /**
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function save()
    {
        $this->validate();

        $post = new Post([
            "title" => $this->title,
            "body" => json_decode($this->body, true),
            "metadata" => [
                "audience" => $this->audience,
                "category" => $this->category,
                "grades" => $this->grades,
                "standards" => $this->standards,
                "practices" => $this->practices,
            ],
            "published" => $this->is_published,
            /** @phpstan-ignore-next-line */
            "user_id" => request()->user()->id,
        ]);
        if ($post->save()) {
            $this->dispatchBrowserEvent("success", [
                "message" => "Post created successfully!",
            ]);
            return redirect()->route("posts.edit", ["post" => $post]);
        } else {
            $this->dispatchBrowserEvent("error", [
                "message" => "Post could not be created.",
            ]);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return view("livewire.create-post");
    }
}
