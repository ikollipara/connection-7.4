<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Comments extends Component
{
    /** @var \App\Models\Post|\App\Models\PostCollection */
    public $item;

    public string $comment_body;

    protected $listeners = ["commentAdded"];

    public function mount($item)
    {
        $this->item = $item;
    }

    public function rules()
    {
        return [
            "comment_body" => ["required", "min:1"],
        ];
    }

    public function save()
    {
        $this->validate();
        $comment = $this->item->comments()->make([
            "body" => "{$this->comment_body}",
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

    public function commentAdded($commentId)
    {
        $this->comment_body = "";
        $this->item->refresh();
    }

    public function render()
    {
        return view("livewire.comments");
    }
}
