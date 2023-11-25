<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
        $user = User::create(
            array_merge(
                $request->validated(),
                [
                    'avatar' => $request
                        ->file('avatar')
                        ->store('avatars', 'public')
                ]
            )
        );
        Auth::login($user);
        Session::flash('success', 'Welcome to ConneCTION!');
        return redirect()->route('home', [], 303);
    }
}
