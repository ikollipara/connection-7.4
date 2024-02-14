<?php

namespace App\Http\Livewire\Password;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Livewire\Component;

class ResetPassword extends Component
{
    public string $email = "";
    public string $password = "";
    public string $password_confirmation = "";
    public string $token = "";

    public function mount(string $token): void
    {
        $this->token = $token;
    }
    protected $rules = [
        "token" => "required",
        "email" => "required|email",
        "password" =>
            "required|confirmed|regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&-+=()]).{12,}$/",
    ];

    public function submit(): void
    {
        $this->validate();

        $status = Password::reset(
            $this->only([
                "email",
                "password",
                "password_confirmation",
                "token",
            ]),
            function ($user, $password) {
                $user
                    ->forceFill([
                        "password" => Hash::make($password),
                    ])
                    ->save();
                event(new PasswordReset($user));
            },
        );
        if ($status === Password::PASSWORD_RESET) {
            $this->redirect(route("login.create"));
            $this->dispatchBrowserEvent("success", ["message" => __($status)]);
        } else {
            // @phpstan-ignore-next-line
            $this->dispatchBrowserEvent("error", ["message" => __($status)]);
        }
    }

    public function render()
    {
        return view("livewire.password.reset-password")->layoutData([
            "title" => "Reset Password",
        ]);
    }
}
