<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
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
        $this->redirect(route("login.create"));
    }

    /** @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory */
    public function render()
    {
        return view("livewire.user.logout");
    }
}
