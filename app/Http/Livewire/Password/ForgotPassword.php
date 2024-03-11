<?php

namespace App\Http\Livewire\Password;

use App\Traits\Livewire\HasDispatch;
use Illuminate\Support\Facades\Password;
use Livewire\Component;

class ForgotPassword extends Component
{
    use HasDispatch;
    public string $email = "";

    /**
     * @var string[]
     */
    protected $rules = [
        "email" => "required|email",
    ];

    public function submit(): void
    {
        $this->validate();

        $status = Password::sendResetLink(["email" => $this->email]);

        $this->dispatchBrowserEvent(
            $status === Password::RESET_LINK_SENT ? "success" : "error",
            ["message" => __($status)],
        );
    }

    // @phpstan-ignore-next-line
    public function render()
    {
        // @phpstan-ignore-next-line
        return view("livewire.password.forgot-password")->layoutData([
            "title" => __("Forgot Password"),
        ]);
    }
}
