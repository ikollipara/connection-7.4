<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

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
            return redirect()->route("home");
        }
        return view("sessions.create");
    }

    public function store(
        LoginRequest $request
    ): \Illuminate\Http\RedirectResponse {
        if (auth()->attempt($request->validated())) {
            $request->session()->regenerate();
            return redirect()->route("home");
        } else {
            return redirect()
                ->route("login.create")
                ->withErrors("error", "Invalid credentials!");
        }
    }

    public function destroy(): \Illuminate\Http\RedirectResponse
    {
        auth()->logout();
        return redirect()->route("index");
    }
}
