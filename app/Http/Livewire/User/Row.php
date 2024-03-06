<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;

class Row extends Component
{
    public User $user;

    public function mount(User $user): void
    {
        $this->user = $user;
    }

    public function render()
    {
        return view("livewire.user.row");
    }
}
