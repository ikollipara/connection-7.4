<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class SignUpForm extends Component
{
    use WithFileUploads;

    public string $first_name;
    public string $last_name;
    public string $email;
    public string $password = "";
    public string $password_confirmation;
    /** @var UploadedFile|null */
    public $avatar = null;
    public string $school;
    public string $subject;
    /** @var array<string> */
    public array $grades;
    public string $bio = '{"blocks":[]}';

    /** @var array<string, array<string>|string> */
    protected $rules = [
        "bio" => ["json", "required"],
        "avatar" => ["image"],
        "grades" => ["array", "required"],
        "subject" => ["required"],
        "school" => ["required"],
        "password_confirmation" => ["same:password", "required"],
        "password" => [
            'regex:/^(?=.*[1-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&-+=()]).{12,}$/',
            "required",
        ],
        "email" => ["email", "required", "unique:\App\Models\User,email"],
        "last_name" => ["string", "required"],
        "first_name" => ["string", "required"],
    ];

    /** @var array<string, string> */
    protected $messages = [
        "password.regex" =>
            'The password needs at least 1 lowercase, one uppercase, one number, one symbol (@#$%^&-+=()), and is at least 12 characters.',
        "password_confirmation.same" => "Must match the password",
    ];

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
        $user = new User([
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "email" => $this->email,
            "password" => $this->password,
            "bio" => $this->bio,
            "grades" => $this->grades,
            "school" => $this->school,
            "subject" => $this->subject,
            "gender" => "",
        ]);
        if ($user->save()) {
            if ($this->avatar) {
                $avatar = $this->avatar->store("avatars", "public");
                if ($avatar) {
                    $user->avatar = $avatar;
                    $user->save();
                }
            }
            auth()->login($user);
            $this->dispatchBrowserEvent("success", [
                "message" => "You have successfully signed up!",
            ]);
            return redirect()->route("home");
        } else {
            $this->dispatchBrowserEvent("error", [
                "message" => "There was an error in your sign up. Try again.",
            ]);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return view("livewire.sign-up-form");
    }
}
