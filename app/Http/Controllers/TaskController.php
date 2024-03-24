<?php

namespace App\Http\Controllers;

use App\Imports\TaskImport; // Class for handling Task import from Excel/CSV
use App\Models\Tasks; // Model representing the tasks table
use App\Models\User; // Model representing the users table (assuming user authentication)
use Illuminate\Database\Eloquent\ModelNotFoundException; // Exception for not found models
use Illuminate\Http\Request; // Represents the incoming HTTP request
use Illuminate\Support\Facades\Auth; // Facade for user authentication
use Illuminate\Support\Facades\DB; // Facade for interacting with the database
use Maatwebsite\Excel\Facades\Excel; // Facade for working with Excel files

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'staff') {
            // Fetch tasks assigned to the logged-in staff user
            $tasks = DB::table('tasks')->where('incharge', $user->user_name)->get();
        } elseif ($user->role == 'admin') {
            // Fetch all tasks for admins
            $tasks = DB::table('tasks')->get();
        } else {
            // Handle other roles if needed
            $tasks = [];
        }

        // Return the task listing view with tasks and user data
        return view('task/tasks', ['tasks' => $tasks, 'user' => $user]);
    }

    /**
     * Import tasks from an uploaded Excel/CSV file.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv,ods',
        ]);

        $path = $request->file('file')->store('temp'); // Store uploaded file temporarily

        $importedTasks = Excel::toArray(new TaskImport, $path); // Import data using TaskImport

        foreach ($importedTasks as $importedTask) {
            $existingTask = Tasks::where('number', $importedTask['number'])->first();

            if ($existingTask) {
                // Handle duplicate tasks (handled in separate method)
                $this->handleDuplicateTask($existingTask, $importedTask);
            } else {
                // Create a new task for non-duplicates
                Tasks::create($importedTask);
            }
        }

        // Redirect to tasks route with success message
        return redirect()->route('tasks')->with('success', 'Data imported successfully.');
    }

    /**
     * Handle duplicate tasks during import (replace and increment resubmission).
     *
     * @param Tasks $existingTask
     * @param array $importedTask
     * @return void
     */
    private function handleDuplicateTask(Tasks $existingTask, array $importedTask)
    {
        // Get resubmission count (handling potential null value)
        $resubmissionCount = $existingTask->resubmission ?? 0;

        // Delete the existing task
        $existingTask->delete();

        // Update imported task data with incremented resubmission
        $importedTask['resubmission'] = $resubmissionCount + 1;

        // Create a new task record with updated data
        Tasks::create($importedTask);
    }

    /**
     * Update the status of a task via AJAX request.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateTaskStatus(Request $request): \Illuminate\Http\JsonResponse
    {
        $task = Tasks::find($request->id); // Find task by ID

        if (!$task) {
            // Handle potential task not found error (can be implemented)
            return response()->json(['error' => 'Task not found'], 404);
        }

        $task->status = $request->status; // Update task status
        $task->save();

        // Return JSON response with success message (can be improved)
        return response()->json(['message' => 'Status updated to ']);
    }
}
