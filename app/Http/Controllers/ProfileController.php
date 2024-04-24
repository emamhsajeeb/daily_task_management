<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Role;
use App\Models\Tasks;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function viewProfile(Request $request): View
    {
        return view('profile.view', [
            'user' => $request->user(),
        ]);
    }
    public function team(Request $request): View
    {
        $user = Auth::user();
        return view('team.members', [
            'user' => $user,
        ]);
    }

    public function members(Request $request)
    {
        $users = User::with('roles')->get();

        $roles = Role::pluck('name');

        $users->transform(function ($user) {
            $tasksCount = Tasks::where('incharge', $user->user_name)->count();
            $completedCount = Tasks::where('incharge', $user->user_name)
                ->where('status', 'completed')
                ->count();

            return [
                'id' => $user->id,
                'userName' => $user->user_name,
                'firstName' => $user->first_name,
                'lastName' => $user->last_name,
                'position' => $user->position,
                'coverImg' => asset("assets/images/users/{$user->user_name}.jpg"),
                'tasksCount' => $tasksCount,
                'completedCount' => $completedCount,
                'role' => $user->roles->pluck('name')->implode(', '),
            ];
        });

        return response()->json(['users' => $users, 'roles' => $roles]);
    }
    /**
     * Display the team's profile form.
     */
    public function edit($id): View
    {
        $user = User::find($id);
        return view('profile.edit', ['user' => $user]);
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

    public function updateUserRole(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'userId' => 'required|exists:users,id', // Ensure userId exists in the users table
                'selectedRole' => 'required|in:admin,manager,visitor,se,qci,aqci' // Validate selected role
            ]);

            // Update the user role
            $user = User::findOrFail($validatedData['userId']);
            // Find the role by name
//            $role = Role::where('name', $validatedData['selectedRole'])->firstOrFail();

            // Sync user's roles
            $user->syncRoles($validatedData['selectedRole']);

            return response()->json(['message' => 'User role updated successfully'], 200);
        } catch (ValidationException $e) {
            // If validation fails, return validation errors
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // If an exception occurs, return an error response
            return response()->json(['message' => 'Failed to update user role'], 500);
        }
    }
}
