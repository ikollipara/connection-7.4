<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;

class Show extends Component
{
    public User $user;
    public string $bio;

    public function mount(User $user): void
    {
        $this->user = $user;
        // @phpstan-ignore-next-line
        $this->bio = json_encode($user->bio);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<\App\Models\Post>
     */
    public function getTopPostsProperty()
    {
        return $this->user
            ->posts()
            ->where("published", true)
            ->orderBy("likes_count", "desc")
            ->orderBy("views", "desc")
            ->limit(10)
            ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<\App\Models\PostCollection>
     */
    public function getTopCollectionsProperty()
    {
        return $this->user
            ->postCollections()
            ->where("published", true)
            ->orderBy("likes_count", "desc")
            ->orderBy("views", "desc")
            ->limit(10)
            ->get();
    }

    public function follow(User $user): void
    {
        if ($user->follow($this->user)) {
            $this->dispatchBrowserEvent("success", [
                "message" => __("Followed!"),
            ]);
        } else {
            $this->dispatchBrowserEvent("error", [
                "message" => __("Failed to follow!"),
            ]);
        }
    }

    public function unfollow(User $user): void
    {
        if ($user->unfollow($this->user)) {
            $this->dispatchBrowserEvent("success", [
                "message" => __("Unfollowed!"),
            ]);
        } else {
            $this->dispatchBrowserEvent("error", [
                "message" => __("Failed to unfollow!"),
            ]);
        }
    }

    /** @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory */
    public function render()
    {
        return view("livewire.user.show");
    }
}
