<?php

namespace App\Http\Livewire;

use App\Models\User;
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
    public string $password;
    public string $password_confirmation;
    public $avatar = null;
    public string $school;
    public string $subject;
    public array $grades;
    public string $bio;

    protected $rules = [
        'bio' => ['json', 'required'],
        'avatar' => ['image'],
        'grades' => ['array', 'required'],
        'subject' => ['required'],
        'school' => ['required'],
        'password_confirmation' => ['same:password', 'required'],
        'password' => ['regex:/^(?=.*[1-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&-+=()]).{12,}$/', 'required'],
        'email' => ['email', 'required', 'unique:\App\Models\User,email'],
        'last_name' => ['string', 'required'],
        'first_name' => ['string', 'required'],
    ];

    protected $messages = [
        'password.regex' => 'The password needs at least 1 lowercase, one uppercase, one number, one symbol (@#$%^&-+=()), and is at least 12 characters.',
        'password_confirmation.same' => 'Must match the password',
    ];

    public function mount()
    {
        $this->bio = json_encode(['blocks' => []]);
        $this->password = '';
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        session()->flash('status', 'There was an error in your sign up. Try again.');
        $this->validate();
        $user = User::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => $this->password,
            'bio' => $this->bio,
            'grades' => $this->grades,
            'school' => $this->school,
            'subject' => $this->subject,
            'gender' => '',
        ]);
        $avatar = $this->avatar->store('avatars');
        $user->avatar = $avatar;
        $user->save();
        auth()->login($user);

        return redirect()
            ->route('home')
            ->with('status', 'Successfully Signed Up');
    }

    public function render()
    {
        return view('livewire.sign-up-form');
    }
}
