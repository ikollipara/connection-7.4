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
    public int $likes_count = 0;
    public int $views_count = 0;

    public function mount(): void
    {
        $this->post_results = collect();
        $this->collection_results = collect();
        $this->results = collect();
    }

    public function search(): void
    {
        $grades_count = count($this->grades);
        $standards_count = count($this->standards);
        $practices_count = count($this->practices);
        $languages_count = count($this->languages);
        $categories_count = count($this->categories);
        $audiences_count = count($this->audiences);

        $post_query = Post::search($this->query)->query(function (
            Builder $query
        ) use (
            $grades_count,
            $standards_count,
            $practices_count,
            $languages_count,
            $categories_count,
            $audiences_count
        ) {
            return $query
                ->where("published", true)
                ->when(
                    $grades_count > 0,
                    fn($query) => $query->whereJsonContains(
                        "metadata->grades",
                        $this->grades,
                    ),
                )
                ->when(
                    $standards_count > 0,
                    fn($query) => $query->whereJsonContains(
                        "metadata->standards",
                        $this->standards,
                    ),
                )
                ->when(
                    $practices_count > 0,
                    fn($query) => $query->whereJsonContains(
                        "metadata->practices",
                        $this->practices,
                    ),
                )
                ->when(
                    $languages_count > 0,
                    fn($query) => $query->whereJsonContains(
                        "metadata->languages",
                        $this->languages,
                    ),
                )
                ->when(
                    $categories_count > 0,
                    fn($query) => $query->whereIn(
                        "metadata->category",
                        $this->categories,
                    ),
                )
                ->when(
                    $audiences_count > 0,
                    fn($query) => $query->whereIn(
                        "metadata->audience",
                        $this->audiences,
                    ),
                )
                ->when(
                    $this->likes_count != 0,
                    fn($query) => $query->where(
                        "likes_count",
                        ">=",
                        $this->likes_count,
                    ),
                )
                ->when(
                    $this->views_count != 0,
                    fn($query) => $query->where(
                        "views",
                        ">=",
                        $this->views_count,
                    ),
                )
                ->orderBy("likes_count", "desc")
                ->orderBy("views", "desc");
        });
        $collection_query = PostCollection::search($this->query)->query(
            function (Builder $query) use (
                $grades_count,
                $standards_count,
                $practices_count,
                $languages_count,
                $categories_count,
                $audiences_count
            ) {
                return $query
                    ->where("published", true)
                    ->when(
                        $grades_count > 0,
                        fn($query) => $query->whereJsonContains(
                            "metadata->grades",
                            $this->grades,
                        ),
                    )
                    ->when(
                        $standards_count > 0,
                        fn($query) => $query->whereJsonContains(
                            "metadata->standards",
                            $this->standards,
                        ),
                    )
                    ->when(
                        $practices_count > 0,
                        fn($query) => $query->whereJsonContains(
                            "metadata->practices",
                            $this->practices,
                        ),
                    )
                    ->when(
                        $languages_count > 0,
                        fn($query) => $query->whereJsonContains(
                            "metadata->languages",
                            $this->languages,
                        ),
                    )
                    ->when(
                        $categories_count > 0,
                        fn($query) => $query->whereIn(
                            "metadata->category",
                            $this->categories,
                        ),
                    )
                    ->when(
                        $audiences_count > 0,
                        fn($query) => $query->whereIn(
                            "metadata->audience",
                            $this->audiences,
                        ),
                    )
                    ->when(
                        $this->likes_count != 0,
                        fn($query) => $query->where(
                            "likes_count",
                            ">=",
                            $this->likes_count,
                        ),
                    )
                    ->when(
                        $this->views_count != 0,
                        fn($query) => $query->where(
                            "views",
                            ">=",
                            $this->views_count,
                        ),
                    )
                    ->orderBy("likes_count", "desc")
                    ->orderBy("views", "desc");
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
