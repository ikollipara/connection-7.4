<?php

namespace App\Http\Livewire;

use App\Models\User;
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

    /** @var array<string> */
    public array $grades;

    /** @var \Illuminate\Http\UploadedFile|null */
    public $avatar = null;

    public string $bio;

    public User $user;

    public function mount(): void
    {
        $user = auth()->user();
        if (!$user) {
            return;
        }
        $this->fill([
            "user" => $user,
            "first_name" => $user->first_name,
            "last_name" => $user->last_name,
            "email" => $user->email,
            "bio" => json_encode($user->bio),
            "school" => $user->school,
            "subject" => $user->subject,
            "grades" => $user->grades,
        ]);
    }

    /**
     * @return array<string, string|array<string>>
     */
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

    public function reset_form(): void
    {
        $this->fill([
            "first_name" => $this->user->first_name,
            "last_name" => $this->user->last_name,
            "email" => $this->user->email,
            "bio" => json_encode($this->user->bio),
            "school" => $this->user->school,
            "subject" => $this->user->subject,
            "grades" => $this->user->grades,
        ]);
        $this->avatar = null;
    }

    public function save(): void
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
            if ($avatar) {
                $user->avatar = $avatar;
            }
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

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return view("livewire.settings");
    }
}
