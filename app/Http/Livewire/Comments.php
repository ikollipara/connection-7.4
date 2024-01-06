<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Comments extends Component
{
    /** @var \App\Models\Post|\App\Models\PostCollection */
    public $item;

    public string $comment_body;

    /** @var array<string> */
    protected $listeners = ["commentAdded"];

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

    public function save(): void
    {
        $this->validate();
        $comment = $this->item->comments()->make([
            "body" => $this->comment_body,
            /** @phpstan-ignore-next-line */
            "user_id" => auth()->user()->id,
        ]);
        if ($comment->save()) {
            $this->emit("commentAdded", $comment->id);
            $this->dispatchBrowserEvent("success", [
                "message" => "Commented successfully!",
            ]);
        } else {
            $this->dispatchBrowserEvent("error", [
                "message" => "Comment could not be saved!",
            ]);
        }
    }

    public function commentAdded(string $commentId): void
    {
        $this->comment_body = "";
        $this->item->refresh();
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return view("livewire.comments");
    }
}
