<?php

namespace App\Http\Livewire\Post;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $status = "draft";
    public User $user;
    public string $search = "";

    public function mount(): void
    {
        $status = request()->query("status", "draft");
        $this->status = $status;
        $user = auth()->user();
        if ($user) {
            $this->user = $user;
        } else {
            $this->redirect(route("login"));
        }
    }

    public function getPostsProperty(): LengthAwarePaginator
    {
        if ($this->search !== "") {
            return $this->user
                ->posts()
                ->status($this->status)
                ->where("title", "like", "%{$this->search}%")
                ->orderByDesc("created_at")
                ->paginate(10);
        }
        return $this->user
            ->posts()
            ->status($this->status)
            ->orderByDesc("created_at")
            ->paginate(10);
    }

    /** @return array<string, string[]|string> */
    public function rules(): array
    {
        return [
            "search" => ["string", "nullable"],
        ];
    }

    public function updatingSearch(string $value): void
    {
        $this->resetPage();
    }

    /** @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory */
    public function render()
    {
        $status = Str::title($this->status);
        return view("livewire.post.index")->layoutData([
            "title" => "ConneCTION " . __("{$status} Posts"),
        ]);
    }
}
