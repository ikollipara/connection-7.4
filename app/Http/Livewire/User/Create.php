<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Illuminate\Http\UploadedFile;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public User $user;

    /** @var UploadedFile|null */
    public $avatar = null;

    public string $password = "";
    public string $password_confirmation = "";

    /** @var string[]|array<string, array<string>> */
    protected $rules = [
        "user.first_name" => "required|string",
        "user.last_name" => "required|string",
        "user.email" => "required|email|unique:users,email",
        "password" => [
            "string",
            'regex:/^(?=.*[1-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&-+=()]).{12,}$/',
            "required",
        ],
        "avatar" => ["image", "nullable"],
        "user.bio" => ["json", "required"],
        "user.grades" => ["array", "required"],
        "user.subject" => ["required"],
        "user.school" => ["required"],
        "password_confirmation" => ["same:password", "required"],
    ];

    /** @var string[] */
    protected $messages = [
        "password.regex" =>
            'The password needs at least 1 lowercase, one uppercase, one number, one symbol (@#$%^&-+=()), and is at least 12 characters.',
        "password_confirmation.same" => "Must match the password",
    ];

    public function mount(): void
    {
        $this->user = new User();
    }

    /**
     * @param mixed $propertyName
     */
    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function save()
    {
        $this->validate();
        $this->user->bio = json_decode($this->user->bio, true);
        $this->user->fill(["password" => $this->password]);
        if ($this->user->save()) {
            if ($this->avatar) {
                $this->user->update([
                    "avatar" => $this->avatar->store("avatars", "public"),
                ]);
            }
            auth()->login($this->user);
            $this->dispatchBrowserEvent("success", [
                "message" => __("You have successfully signed up!"),
            ]);
            return redirect()->route("home");
        } else {
            $this->dispatchBrowserEvent("error", [
                "message" => __("There was an error signing up."),
            ]);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return view("livewire.user.create")->layoutData([
            "title" => "ConneCTION " . __("Sign Up"),
        ]);
    }
}
