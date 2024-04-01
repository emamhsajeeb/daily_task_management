<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function assignAdminRole($userId)
    {
        $user = User::findOrFail($userId); // Retrieve the user by ID

        // Assign the 'admin' role to the user
        $user->assignRole('admin');

        return response()->json(['message' => 'Admin role assigned successfully'], 200);
    }
}
