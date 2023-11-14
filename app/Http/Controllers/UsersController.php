<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', ['user' => $user->with(['posts', 'post_collections'])->get()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\RegistrationRequest $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(RegistrationRequest $request, User $user)
    {
        if ($user->update($request->validated())) {
            return redirect()
                ->route('users.show', ['user' => $user])
                ->with('success', 'Profile updated successfully!');
        } else {
            return redirect()
                ->route('users.edit', ['user' => $user])
                ->with('error', 'Profile update failed!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        Auth::logout();
        Auth::logoutOtherDevices($user->password);
        $user->delete();
    }
}
