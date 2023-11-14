<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class RegistrationController extends Controller
{
    public function create()
    {
        if ($this->current_user()) {
            return redirect()->route('home');
        }
        return view('registration.create');
    }

    public function store(RegistrationRequest $request)
    {
        $user = \App\Models\User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'school' => $request->school,
            'grades' => $request->grades,
            'bio' => $request->bio,
            'subject' => $request->subject,
            'gender' => $request->gender,
            'email' => $request->email,
            'password' => $request->password,
            'avatar' => $request->file('avatar')->store('avatars', 'public') ?? '',
        ]);
        Auth::login($user);
        Session::flash('success', 'Welcome to ConneCTION!');
        return redirect()->route('home');
    }
}
