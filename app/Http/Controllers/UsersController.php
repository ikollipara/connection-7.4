<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

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
        return Inertia::render(
            'Users/Show',
            ['user' => $user->with(['posts', 'postCollections'])->get()]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return Inertia::render('Users/Edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        if ($user->update($request->validated())) {
            return redirect()
                ->route('users.show', ['user' => $user], 303)
                ->with('success', 'Profile updated successfully!');
        } else {
            return redirect()
                ->route('users.edit', ['user' => $user], 303)
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
        $this->authorize('delete', $user);
        Auth::logout();
        Auth::logoutOtherDevices($user->password);
        $user->delete();
        return redirect()
            ->route('index', [], 303)
            ->with('success', 'Account deleted successfully!');
    }
}
