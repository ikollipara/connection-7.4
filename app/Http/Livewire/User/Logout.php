<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Logout extends Component
{
    public User $user;

    public function mount(User $user): void
    {
        $this->user = $user;
    }

    public function logout(): void
    {
        auth()->logout();
        /* @phpstan-ignore-next-line */
        session()->invalidate();
        /* @phpstan-ignore-next-line */
        session()->regenerateToken();
        $this->redirect(route("login.create"));
    }

    /** @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory */
    public function render()
    {
        return view("livewire.user.logout");
    }
}
