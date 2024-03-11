<?php

namespace App\Http\Livewire\User;

use Livewire\Component;

class Logout extends Component
{
    public function logout(): void
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        $this->redirect(route("login.create"));
    }

    /** @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory */
    public function render()
    {
        return view("livewire.user.logout");
    }
}
