<?php

namespace App\Http\Livewire;

use App\Enums\Audience;
use App\Enums\Category;
use App\Models\PostCollection;
use Livewire\Component;

class CreateCollection extends Component
{
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
     *  @return \Illuminate\Http\RedirectResponse|void
     */
    public function save()
    {
        $this->validate();

        $collection = new PostCollection([
            "title" => $this->title,
            "body" => json_decode($this->body, true),
            /** @phpstan-ignore-next-line */
            "user_id" => request()->user()->id,
            "metadata" => [
                "audience" => $this->audience,
                "category" => $this->category,
                "grades" => $this->grades,
                "standards" => $this->standards,
                "practices" => $this->practices,
            ],
        ]);

        if ($collection->save()) {
            $this->dispatchBrowserEvent("success", [
                "message" => "Collection created successfully!",
            ]);
            return redirect()->route("collections.edit", [
                "post_collection" => $collection,
            ]);
        } else {
            $this->dispatchBrowserEvent("error", [
                "message" => "Collection could not be created!",
            ]);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return view("livewire.create-collection");
    }
}
