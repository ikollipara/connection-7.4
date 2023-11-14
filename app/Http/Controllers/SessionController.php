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
        Auth::attempt($request->validated());
        return redirect()->route('home');
    }

    public function destroy()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
