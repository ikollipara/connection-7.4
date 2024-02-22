<?php

namespace App\Http\Livewire\User;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Login extends Component
{
    public string $email = "";
    public string $password = "";
    public bool $remember_me = false;

    /** @var string[] */
    protected $rules = [
        "email" => "required|email|exists:users,email",
        "password" => "required",
        "remember_me" => "boolean",
    ];

    /**
     * @return void|\Illuminate\Http\RedirectResponse
     */
    public function mount()
    {
        if (auth()->check()) {
            return redirect()->route("home");
        }
    }

    /**
     * @return void|\Illuminate\Http\RedirectResponse
     */
    public function login()
    {
        $this->validate();

        if (
            auth()->attempt(
                $this->only(["email", "password"]),
                $this->remember_me,
            )
        ) {
            session()->regenerate();
            return redirect()->intended(route("home"), 303);
        } else {
            Log::info("User {$this->email} failed to log in.");
            $this->dispatchBrowserEvent("error", [
                "message" => __("Invalid credentials!"),
            ]);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return view("livewire.user.login")->layoutData([
            "title" => "ConneCTION " . __("Login"),
        ]);
    }
}
