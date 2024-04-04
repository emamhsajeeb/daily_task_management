<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function viewProfile(Request $request): View
    {
        return view('profile.view', [
            'team' => $request->user(),
        ]);
    }
    public function team(Request $request): View
    {
        $users = User::all();
        $roles = Role::all();
        // Add a new column to users based on their roles
        $users->each(function ($user) {
            $user->role = $user->roles->pluck('name')->implode(', '); // Concatenate role names
        });
        return view('team.members', [
            'users' => $users,
            'roles' => $roles,
            'team' => $request->user()
        ]);
    }
    /**
     * Display the team's profile form.
     */
    public function edit($id): View
    {
        $user = User::find($id);
        return view('profile.edit', ['team' => $user]);
    }

    /**
     * Update the team's profile information.
     */
    public function update(ProfileUpdateRequest $request, $id): RedirectResponse
    {

        $user = User::find($id);
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;  // Reset email verification if email changed
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the team's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
