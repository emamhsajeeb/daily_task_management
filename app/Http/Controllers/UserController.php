<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function assignAdminRole($userId)
    {
        $user = User::findOrFail($userId); // Retrieve the team by ID

        // Assign the 'admin' role to the team
        $user->assignRole('admin');

        return response()->json(['message' => 'Admin role assigned successfully'], 200);
    }
}
