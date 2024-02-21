<?php

namespace App\Http\Livewire;

use App\Models\Post;
use App\Models\PostCollection;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class Search extends Component
{
    use WithPagination;

    /** @var string */
    public $query = "";
    public string $type = "";
    public $results;
    /** @var \Illuminate\Support\Collection<Post>|Collection<Post> */
    public $post_results;
    /** @var \Illuminate\Support\Collection<PostCollection>|Collection<PostCollection> */
    public $collection_results;
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
    /** @var array<\App\Enums\Language> */
    public array $languages = [];

    public function mount(): void
    {
        $this->post_results = collect();
        $this->collection_results = collect();
        $this->results = collect();
    }

    public function search(): void
    {
        $post_query = Post::search($this->query)->query(function (
            Builder $query
        ) {
            $query
                ->whereJsonContains("metadata->grades", $this->grades)
                ->whereJsonContains("metadata->standards", $this->standards)
                ->whereJsonContains("metadata->practices", $this->practices);
            if (count($this->languages) > 0) {
                $query->whereJsonContains(
                    "metadata->languages",
                    $this->languages,
                );
            }
            if (count($this->categories) > 0) {
                $query->whereIn("metadata->category", $this->categories);
            }
            if (count($this->audiences) > 0) {
                $query->whereIn("metadata->audience", $this->audiences);
            }
        });
        $collection_query = PostCollection::search($this->query)->query(
            function (Builder $query) {
                $query
                    ->whereJsonContains("metadata->grades", $this->grades)
                    ->whereJsonContains("metadata->standards", $this->standards)
                    ->whereJsonContains(
                        "metadata->practices",
                        $this->practices,
                    );
                if (count($this->languages) > 0) {
                    $query->whereJsonContains(
                        "metadata->languages",
                        $this->languages,
                    );
                }
                if (count($this->categories) > 0) {
                    $query->whereIn("metadata->category", $this->categories);
                }
                if (count($this->audiences) > 0) {
                    $query->whereIn("metadata->audience", $this->audiences);
                }
            },
        );
        if ($this->type === "post") {
            $this->post_results = $post_query->get();
        } elseif ($this->type === "collection") {
            $this->collection_results = $collection_query->get();
        } else {
            $this->post_results = $post_query->get();
            $this->collection_results = $collection_query->get();
        }
        $this->results = collect(
            array_merge(
                $this->post_results->all(),
                $this->collection_results->all(),
            ),
        )->sortBy([["likes_count", "desc"], ["views", "desc"]]);
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return view("livewire.search")->layoutData([
            "title" => "ConneCTION - " . __("Search"),
        ]);
    }
}
