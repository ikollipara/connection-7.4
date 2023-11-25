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

    public array $grades = [];

    public array $standards = [];

    public array $practices = [];

    public string $category = Category::Material;

    public string $audience = Audience::Students;

    public function rules()
    {
        return [
            "title" => "string",
            "body" => "json",
        ];
    }

    public function save()
    {
        $this->validate();

        $collection = new PostCollection([
            "title" => $this->title,
            "body" => json_decode($this->body, true),
            "user_id" => auth()->user()->id,
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

    public function render()
    {
        return view("livewire.create-collection");
    }
}
