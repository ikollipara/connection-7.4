<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Notifications\CommentAdded;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Comments extends Component
{
    /** @var \App\Models\Post|\App\Models\PostCollection */
    public $item;

    public string $comment_body;

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

    /**
     *
     * @return Collection<Comment>
     */
    public function getCommentsProperty()
    {
        return $this->item
            ->comments()
            ->with("user")
            ->get();
    }

    public function save(): void
    {
        $this->validate();
        $comment = $this->item->comments()->make([
            "body" => $this->comment_body,
            /** @phpstan-ignore-next-line */
            "user_id" => auth()->user()->id,
        ]);
        if ($comment->save()) {
            $this->comment_body = "";
            $this->dispatchBrowserEvent("success", [
                "message" => "Commented successfully!",
            ]);
            $commenter = $comment->user;
            if (($user = $this->item->user) and $commenter) {
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
