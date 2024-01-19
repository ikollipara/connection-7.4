<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        Log::info("Email verified for user {$request->user()->id}.");
        return redirect()->route("home");
    }

    public function resend(Request $request): \Illuminate\Http\RedirectResponse
    {
        /** @var \App\Models\User */
        $user = $request->user();

        $user->sendEmailVerificationNotification();

        Log::info("Verification link resent for user {$user->id}.");

        return back()->with("message", "Verification link sent!");
    }
}
