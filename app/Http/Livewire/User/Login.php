<?php

namespace App\Http\Livewire\User;

use App\Traits\Livewire\HasDispatch;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Login extends Component
{
    use HasDispatch;
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
            !auth()->attempt(
                $this->only(["email", "password"]),
                $this->remember_me,
            )
        ) {
            Log::info("User {$this->email} failed to log in.");
            $this->dispatchBrowserEvent("error", [
                "message" => __("Invalid credentials!"),
            ]);
            return;
        }
        session()->regenerate();
        return redirect()->to(route("home"), 303);
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
