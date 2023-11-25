<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function create()
    {
        if ($this->current_user()) {
            return redirect()->route('home');
        }
        return view('sessions.create');
    }

    public function store(LoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }
    }

    public function destroy()
    {
        Auth::logout();
        return redirect()->route('index');
    }
}
