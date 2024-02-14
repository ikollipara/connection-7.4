<?php

namespace App\Http\Livewire;

use App\Mail\FAQQuestion;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class SubmitFAQQuestion extends Component
{
    public string $question = "";
    public User $user;

    public function mount(): void
    {
        if ($user = auth()->user()) {
            $this->user = $user;
        } else {
            $this->redirect(route("login"));
        }
    }

    public function submitQuestion(): void
    {
        $this->validate([
            "question" => "required|string",
        ]);

        Mail::send(new FAQQuestion($this->question, $this->user));

        $this->question = "";
        $this->dispatchBrowserEvent("success", [
            "message" => "Question submitted!",
        ]);
        $this->dispatchBrowserEvent("question-submitted");
    }

    /**
     *
     * @return View|Factory
     * @throws BindingResolutionException
     */
    public function render()
    {
        return view("livewire.submit-f-a-q-question");
    }
}
