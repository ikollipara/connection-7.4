<?php

namespace App\Http\Livewire;

use App\Models\Post;
use App\Models\PostCollection;
use App\Models\User;
use Livewire\Component;

class Search extends Component
{
    protected $queryString = [
        "query" => ["as" => "q"],
    ];

    public $query;
    public string $type = "";
    /** @var array<\App\Models\Post|\App\Models\PostCollection> */
    public array $results = [];
    /** @var array<\App\Enums\Category> */
    public array $categories = [];
    /** @var array<\App\Enums\Audience> */
    public array $audiences = [];
    /** @var array<\App\Enums\Grade> */
    public array $grades = [];
    /** @var array<\App\Enums\Standard> */
    public array $standards = [];
    /** @var array<\App\Enums\Practice> */
    public array $practices = [];

    public function mount()
    {
        if ($this->query) {
            $this->search();
        }
    }

    public function search()
    {
        if ($this->type === "") {
            $this->results = array_merge(
                array_map(
                    function ($post_array) {
                        $post_array["type"] = "post";
                        $post_array["user"] = User::find(
                            $post_array["user_id"],
                        )->full_name();
                        return $post_array;
                    },
                    Post::search($this->query)
                        ->get()
                        ->toArray(),
                ),
                array_map(
                    function ($collection_array) {
                        $collection_array["type"] = "collection";
                        $collection_array["user"] = User::find(
                            $collection_array["user_id"],
                        )->full_name();
                        return $collection_array;
                    },
                    PostCollection::search($this->query)
                        ->get()
                        ->toArray(),
                ),
            );
        } elseif ($this->type === "post") {
            $this->results = Post::search($this->query)
                ->get()
                ->toArray();
        } elseif ($this->type === "collection") {
            $this->results = PostCollection::search($this->query)
                ->get()
                ->toArray();
        }

        if ($this->standards) {
            $this->results = array_filter($this->results, function ($item) {
                count(array_intersect($item["standards"], $this->standards)) >
                    0;
            });
        }
        if ($this->practices) {
            $this->results = array_filter($this->results, function ($item) {
                count(array_intersect($item["practices"], $this->practices)) >
                    0;
            });
        }
        if ($this->grades) {
            $this->results = array_filter($this->results, function ($item) {
                count(array_intersect($item["grades"], $this->grades)) > 0;
            });
        }
        if ($this->categories) {
            $this->results = array_filter($this->results, function ($item) {
                in_array($item["category"], $this->categories);
            });
        }
        if ($this->audiences) {
            $this->results = array_filter($this->results, function ($item) {
                in_array($item["audiences"], $this->audiences);
            });
        }
    }

    public function render()
    {
        return view("livewire.search");
    }
}
