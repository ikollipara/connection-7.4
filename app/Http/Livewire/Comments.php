<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Notifications\CommentAdded;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class Comments extends Component
{
    use WithPagination;

    /** @var \App\Models\Post|\App\Models\PostCollection */
    public $item;

    public string $comment_body = "";

    /**
     * @param \App\Models\Post|\App\Models\PostCollection $item
     */
    public function mount($item): void
    {
        $this->item = $item;
    }

    /**
     * @return array<string, string|array<string>>
     */
    public function rules()
    {
        return [
            "comment_body" => ["required", "min:1"],
        ];
    }

    public function getCommentsProperty(): LengthAwarePaginator
    {
        return $this->item
            ->comments()
            ->orderByDesc("created_at")
            ->with("user")
            ->paginate(10);
    }

    public function save(): void
    {
        $this->validate();
        $comment = $this->item->comments()->make([
            "user_id" => auth()->id(),
            "body" => $this->comment_body,
        ]);
        if ($comment->save()) {
            $this->dispatchBrowserEvent("success", [
                "message" => "Commented successfully!",
            ]);
            $this->comment_body = "";
            $commenter = $comment->user;
            if (
                ($user = $this->item->user) and
                $commenter and
                !$user->no_comment_notifications
            ) {
                $user->notify(
                    new CommentAdded(
                        $comment,
                        $commenter,
                        $this->item instanceof \App\Models\Post,
                    ),
                );
            }
        } else {
            $this->dispatchBrowserEvent("error", [
                "message" => "Comment could not be saved!",
            ]);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return view("livewire.comments");
    }
}
