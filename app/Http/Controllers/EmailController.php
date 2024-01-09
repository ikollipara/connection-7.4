<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function verify(): \Illuminate\View\View
    {
        return view("auth.verify-email");
    }

    public function validateHash(
        EmailVerificationRequest $request
    ): \Illuminate\Http\RedirectResponse {
        $request->fulfill();

        return redirect()->to(route("home"));
    }

    public function resend(Request $request): \Illuminate\Http\RedirectResponse
    {
        /** @var \App\Models\User */
        $user = $request->user();

        $user->sendEmailVerificationNotification();

        return back()->with("message", "Verification link sent!");
    }
}
