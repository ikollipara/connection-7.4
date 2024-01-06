<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        return view("auth.forgot-password");
    }

    public function create(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate(["email" => "required|email"]);

        $status = Password::sendResetLink($request->only("email"));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(["status" => __($status)])
            : back()->withErrors(["email" => __($status)]);
    }

    public function show(string $token): \Illuminate\View\View
    {
        return view("auth.reset-password", ["token" => $token]);
    }

    public function update(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            "token" => "required",
            "email" => "required|email",
            "password" =>
                "required|confirmed|regex:/^(?=.*[1-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&-+=()]).{12,}$/",
        ]);

        /** @var string */
        $status = Password::reset(
            $request->only(
                "email",
                "password",
                "password_confirmation",
                "token",
            ),
            function ($user, $request) {
                $user
                    ->forceFill([
                        "password" => Hash::make($request->password),
                    ])
                    ->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            },
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()
                ->route("login.create")
                ->with(["status" => __($status)])
            : back()->withErrors(["email" => __($status)]);
    }
}
