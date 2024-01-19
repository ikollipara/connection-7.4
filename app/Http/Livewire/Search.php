<?php

namespace App\Http\Livewire;

use App\Models\Post;
use App\Models\PostCollection;
use App\Models\User;
use Livewire\Component;

class Search extends Component
{
    /**
     * @var array<string, array<string, string>>
     */

    /** @var string */
    public $query = "";
    public string $type = "";
    /** @var array<array<string, mixed>> */
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

    public function mount(): void
    {
    }

    /**
     * @param array<string, mixed> $post_or_post_collection_array
     * @return array<string, mixed>
     */
    protected function fillUserFullName(
        array $post_or_post_collection_array
    ): array {
        /** @var User|null */
        $user = User::find($post_or_post_collection_array["user_id"]);
        if ($user) {
            $post_or_post_collection_array["user"] = $user->full_name();
        } else {
            $post_or_post_collection_array["user"] = "[Deleted]";
        }
        return $post_or_post_collection_array;
    }

    public function search(): void
    {
        if ($this->type === "") {
            $this->results = array_merge(
                array_map(
                    /** @phpstan-ignore-next-line */
                    function (array $post_array): array {
                        $post_array["type"] = "post";
                        return $this->fillUserFullName($post_array);
                    },
                    Post::search($this->query)
                        ->get()
                        ->toArray(),
                ),
                array_map(
                    /** @phpstan-ignore-next-line */
                    function (array $collection_array) {
                        $collection_array["type"] = "collection";
                        return $this->fillUserFullName($collection_array);
                    },
                    PostCollection::search($this->query)
                        ->get()
                        ->toArray(),
                ),
            );
        } elseif ($this->type === "post") {
            $this->results = array_map(
                /** @phpstan-ignore-next-line */
                fn(array $post_array) => $this->fillUserFullName($post_array),
                Post::search($this->query)
                    ->get()
                    ->toArray(),
            );
        } elseif ($this->type === "collection") {
            $this->results = array_map(
                /** @phpstan-ignore-next-line */
                fn(array $collection_array) => $this->fillUserFullName(
                    $collection_array,
                ),
                PostCollection::search($this->query)
                    ->get()
                    ->toArray(),
            );
        }

        if ($this->standards) {
            $this->results = array_filter(
                $this->results,
                /**
                 * @param array<string, array<string, mixed>> $item
                 */
                function (array $item) {
                    return count(
                        /** @phpstan-ignore-next-line */
                        array_intersect(
                            $item["metadata"]["standards"],
                            $this->standards,
                        ),
                    ) > 0;
                },
            );
        }
        if ($this->practices) {
            $this->results = array_filter(
                $this->results,
                /**
                 * @param array<string, array<string, mixed>> $item
                 */
                function (array $item) {
                    return count(
                        /** @phpstan-ignore-next-line */
                        array_intersect(
                            $item["metadata"]["practices"],
                            $this->practices,
                        ),
                    ) > 0;
                },
            );
        }
        if ($this->grades) {
            $this->results = array_filter(
                $this->results,
                /**
                 * @param array<string, array<string, mixed>> $item
                 */
                function (array $item) {
                    return count(
                        /** @phpstan-ignore-next-line */
                        array_intersect(
                            $item["metadata"]["grades"],
                            $this->grades,
                        ),
                    ) > 0;
                },
            );
        }
        if ($this->categories) {
            $this->results = array_filter(
                $this->results,
                fn(array $item) => in_array(
                    $item["metadata"]["category"],
                    $this->categories,
                ),
            );
        }
        if ($this->audiences) {
            $this->results = array_filter(
                $this->results,
                fn(array $item) => in_array(
                    $item["metadata"]["audience"],
                    $this->audiences,
                ),
            );
        }
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return view("livewire.search");
    }
}
