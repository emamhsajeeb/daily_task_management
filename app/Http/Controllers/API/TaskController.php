<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $user = Auth::guard('sanctum')->user();

        if ($user->role === 'staff') {
            $tasks = DB::table('tasks')
                ->where('incharge', $user->user_name)
                ->get();
        } elseif ($user->role === 'admin') {
            $tasks = DB::table('tasks')
                ->get();
        } else {
            return response()->json(['error' => 'Unauthorized role'], 403); // Handle unauthorized roles gracefully
        }

        return response()->json(compact('tasks'), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
