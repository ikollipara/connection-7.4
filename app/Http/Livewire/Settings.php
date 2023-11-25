<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Settings extends Component
{
    use WithFileUploads;

    public string $first_name;

    public string $last_name;

    public string $email;

    public string $school;

    public string $subject;

    public array $grades;

    public $avatar = null;

    public string $bio;

    public function mount()
    {
        $this->fill([
            "first_name" => auth()->user()->first_name,
            "last_name" => auth()->user()->last_name,
            "email" => auth()->user()->email,
            "bio" => json_encode(auth()->user()->bio),
            "school" => auth()->user()->school,
            "subject" => auth()->user()->subject,
            "grades" => auth()->user()->grades,
        ]);
    }

    public function rules()
    {
        return [
            "first_name" => ["string", "required"],
            "last_name" => ["string", "required"],
            "email" => ["email", "required"],
            "bio" => ["json", "required"],
            "subject" => ["string", "required"],
            "school" => ["string", "required"],
            "grades" => ["array", "required"],
            "avatar" => ["image", "nullable"],
        ];
    }

    public function reset_form()
    {
        $this->fill([
            "first_name" => auth()->user()->first_name,
            "last_name" => auth()->user()->last_name,
            "email" => auth()->user()->email,
            "bio" => json_encode(auth()->user()->bio),
            "school" => auth()->user()->school,
            "subject" => auth()->user()->subject,
            "grades" => auth()->user()->grades,
        ]);
        $this->avatar = null;
    }

    public function save()
    {
        /** @var \App\Models\User */
        $user = auth()->user();
        $this->validate();
        $user->fill([
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "email" => $this->email,
            "subject" => $this->subject,
            "school" => $this->school,
            "grades" => $this->grades,
            "bio" => json_decode($this->bio, true),
        ]);
        if ($this->avatar) {
            $avatar = $this->avatar->store("avatars", "public");
            $user->avatar = $avatar;
        }
        if ($user->save()) {
            $this->emit("success", ["message" => "Successfully Updated!"]);
            $this->dispatchBrowserEvent("editor-saved");
            if ($this->avatar) {
                $this->emit("avatarUpdated", $user->avatar_url());
            }
            $this->reset_form();
        } else {
            $this->emit("error", ["message" => "Failed to update!"]);
        }
    }

    public function render()
    {
        return view("livewire.settings");
    }
}
