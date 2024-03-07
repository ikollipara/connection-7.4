<?php

namespace App\Http\Livewire;

use App\Models\Post;
use App\Models\PostCollection;
use App\Models\User;
use Livewire\Component;

class Home extends Component
{
    public User $user;

    public function mount()
    {
        if (!($this->user = auth()->user())) {
            return redirect()->route("login.create");
        }
        $this->user->load("posts", "postCollections", "following");
    }

    /** @return \Illuminate\Support\Collection<\App\Models\Post|\App\Models\PostCollection> */
    public function getFollowingsItemsProperty()
    {
        return $this->user
            ->load([
                "following",
                "following.posts",
                "following.postCollections",
            ])
            ->following->flatMap(function (User $user) {
                return [
                    "posts" => $user
                        ->posts()
                        ->where("published", true)
                        ->latest()
                        ->take(10)
                        ->with("user")
                        ->get(),
                    "postCollections" => $user
                        ->postCollections()
                        ->where("published", true)
                        ->latest()
                        ->take(10)
                        ->with("user")
                        ->get(),
                ];
            })
            ->flatten();
    }

    /** @return \Illuminate\Database\Eloquent\Collection<\App\Models\Post> */
    public function getTopPostsProperty()
    {
        return Post::query()
            ->where("published", true)
            ->orderBy("likes_count", "desc")
            ->orderBy("views", "desc")
            ->take(10)
            ->with("user")
            ->get();
    }

    /** @return \Illuminate\Database\Eloquent\Collection<\App\Models\PostCollection> */
    public function getTopCollectionsProperty()
    {
        return PostCollection::query()
            ->where("published", true)
            ->orderBy("likes_count", "desc")
            ->orderBy("views", "desc")
            ->take(10)
            ->with("user")
            ->get();
    }

    public function render()
    {
        return view("livewire.home")->layoutData([
            "title" => "ConneCTION - " . __("Home"),
        ]);
    }
}
