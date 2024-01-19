<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SessionController extends Controller
{
    /**
     * Show Creation Form
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        if ($this->current_user()) {
            Log::info("User {$this->current_user()->id} already logged in.");
            return redirect()->route("home");
        }
        return view("sessions.create");
    }

    public function store(
        LoginRequest $request
    ): \Illuminate\Http\RedirectResponse {
        if (auth()->attempt($request->validated())) {
            $request->session()->regenerate();
            Log::info("User {$request->email} logged in.");
            return redirect()->route("home");
        } else {
            Log::info("User {$request->email} failed to log in.");
            return redirect()
                ->route("login.create")
                ->withErrors("error", "Invalid credentials!");
        }
    }

    public function destroy(): \Illuminate\Http\RedirectResponse
    {
        Log::info("User {$this->current_user()->id} logged out.");
        auth()->logout();
        return redirect()->route("index");
    }
}
