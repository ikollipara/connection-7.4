<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RegistrationController extends Controller
{
    /**
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        if ($this->current_user()) {
            return redirect()->route("home");
        }
        return view("registration.create");
    }

    public function store(RegistrationRequest $request): RedirectResponse
    {
        $user = new User($request->validated());
        if (
            ($avatar = $request->file("avatar")) and
            $avatar instanceof UploadedFile
        ) {
            if ($path = $avatar->store("avatars", "public")) {
                $user->avatar = $path;
            }
        }
        if ($user->save()) {
            auth()->login($user);
            Session::flash("success", "Welcome to ConneCTION!");
            return redirect()->route("home", [], 303);
        } else {
            Session::flash("error", "Something went wrong!");
            return redirect()->route("registration.create", [], 303);
        }
    }
}
