<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use App\Traits\Livewire\HasDispatch;
use Livewire\Component;
use Illuminate\Http\UploadedFile;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads, HasDispatch;

    public User $user;

    /** @var UploadedFile|null */
    public $avatar = null;

    public string $password = "";
    public string $password_confirmation = "";
    public string $full_name = "";
    public bool $above_19 = false;

    /** @var string[]|array<string, array<string>> */
    protected $rules = [
        "user.first_name" => "required|string",
        "user.last_name" => "required|string",
        "above_19" => "required|boolean",
        "full_name" => "string|required",
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
        "user.years_of_experience" => ["required", "integer", "min:0"],
        "user.is_preservice" => ["required", "boolean"],
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

    public function updatedUserBio(): void
    {
        // @phpstan-ignore-next-line
        $this->user->bio = json_decode($this->user->bio, true);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function save()
    {
        $this->validate();
        $this->user->fill(["password" => $this->password]);
        if ($this->above_19 and $this->full_name === $this->user->full_name()) {
            $this->user->consented = true;
        }
        $this->dispatchBrowserEventIf(!$this->user->save(), "error", [
            "message" => __(
                "There was an error signing up. {$this->errorBag->all()}",
            ),
        ]);
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
