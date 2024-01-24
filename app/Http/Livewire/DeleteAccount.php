<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class DeleteAccount extends Component
{
    public User $user;
    public string $password = "";
    public string $password_confirmation = "";

    /**
     * @var string[]
     */
    protected $rules = [
        "password" => "required|password",
        "password_confirmation" => "required|same:password",
    ];

    public function mount(User $user): void
    {
        $this->user = $user;
    }

    /**
     *  @return \Illuminate\Http\RedirectResponse|void
     */
    public function destroy()
    {
        $this->validate();
        if (!Hash::check($this->password, $this->user->password)) {
            $this->dispatchBrowserEvent("error", [
                "message" => "Password is incorrect!",
            ]);
            return;
        }
        if ($this->user->delete()) {
            auth()->logout();
            return redirect()
                ->route("index", [], 303)
                ->with("success", "Account deleted successfully!");
        } else {
            $this->dispatchBrowserEvent("error", [
                "message" => "Account deletion failed!",
            ]);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return view("livewire.delete-account");
    }
}
