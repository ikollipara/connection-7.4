<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

class VerifyEmail extends Component
{
    public function resend(): void
    {
        /** @var \App\Models\User */
        $user = auth()->user();

        $user->sendEmailVerificationNotification();

        Log::info("Verification link resent for user " . $user->id . ".");

        $this->dispatchBrowserEvent("success", [
            "message" => __("Verification link sent!"),
        ]);
    }

    public function render()
    {
        return view("livewire.verify-email")->layoutData([
            "title" => "ConneCTION" . __("Verify Email"),
        ]);
    }
}
