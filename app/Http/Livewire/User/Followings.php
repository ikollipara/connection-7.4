<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Followings extends Component
{
    use WithPagination;
    public User $user;
    public string $search = "";

    public function mount(User $user): void
    {
        $this->user = $user;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    /** @return \Illuminate\Database\Eloquent\Collection<User> */
    public function getFollowingsProperty()
    {
        // @phpstan-ignore-next-line
        return $this->user
            ->following()
            ->latest()
            ->when($this->search, function ($query) {
                $query
                    ->where("first_name", "like", "%{$this->search}%")
                    ->orWhere("last_name", "like", "%{$this->search}%");
            })
            ->paginate(10);
    }
    public function render()
    {
        return view("livewire.user.followings")->layoutData([
            "title" =>
                "ConneCTION" . __("Followings of ") . $this->user->full_name(),
        ]);
    }
}
