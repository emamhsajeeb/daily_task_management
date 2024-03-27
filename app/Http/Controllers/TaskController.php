<?php

namespace App\Http\Controllers;

use App\Http\Controllers\PushNotificationController;
use App\Imports\TaskImport; // Class for handling Task import from Excel/CSV
use App\Models\Tasks; // Model representing the tasks table
use App\Models\User; // Model representing the users table (assuming user authentication)
use DateTime;
use Illuminate\Database\Eloquent\ModelNotFoundException; // Exception for not found models
use Illuminate\Http\Request; // Represents the incoming HTTP request
use Illuminate\Support\Facades\Auth; // Facade for user authentication
use Illuminate\Support\Facades\DB; // Facade for interacting with the database
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel; // Facade for working with Excel files

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     *
     * @return
     */
    public function showTasks()
    {
        $settings = [
            'title' => 'All Tasks',
        ];
        $user = Auth::user();
        $tasks = $user ? (
        $user->role === 'staff'
            ? DB::table('tasks')->where('incharge', $user->user_name)->get()
            : (Auth::user()->role === 'admin' ? DB::table('tasks')->get() : [])
        ) : [];

        return view('task/tasks', compact('tasks', 'user', 'settings'));
    }

    public function importTasks()
    {
        $settings = [
            'title' => 'Import Tasks',
        ];
        $user = Auth::user();
        return view('task/import',compact('user', 'settings'));
    }

    /**
     * Import tasks from an uploaded Excel/CSV file.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importCSV(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv,ods',
        ]);

        $path = $request->file('file')->store('temp'); // Store uploaded file temporarily

        $importedTasks = Excel::toArray(new TaskImport, $path)[0]; // Import data using TaskImport

        $newSubmissionCount = 0;
        $resubmissionCount = 0;
        $date = $importedTasks[0][0];

        foreach ($importedTasks as $importedTask) {

            $inchargeName = '';
            $k = intval(substr($importedTask[5], 1)); // Extracting the numeric part after 'K'

            switch (true) {
                case ($k > -1 && $k <= 12):
                    $inchargeName = 'habibur';
                    break;
                case ($k >= 13 && $k <= 21):
                    $inchargeName = 'prodip';
                    break;
                case ($k >= 22 && $k <= 33):
                    $inchargeName = 'debashis';
                    break;
                case ($k >= 34 && $k <= 48):
                    $inchargeName = 'rabbi';
                    break;
            }

            $existingTask = Tasks::where('number', $importedTask[1])->first();

            if ($existingTask) {
                $resubmissionCount++;
                // Handle duplicate tasks (handled in separate method)
                $this->handleDuplicateTask($existingTask, $importedTask, $inchargeName);
            } else {
                $newSubmissionCount++;
                // Create a new task for non-duplicates
                Tasks::create([
                    'date' => $importedTask[0],
                    'number' => $importedTask[1],
                    'status' => $importedTask[2],
                    'type' => $importedTask[3],
                    'description' => $importedTask[4],
                    'location' => $importedTask[5],
                    'side' => $importedTask[6],
                    'qty_layer' => $importedTask[7],
                    'planned_time' => $importedTask[8],
                    'incharge' => $inchargeName,
                ]);
            }
        }
        $title = "Daily tasks updated for {$date}";
        $message = "$newSubmissionCount " . ($newSubmissionCount > 1 ? "new submissions" : "new submission") . " and $resubmissionCount resubmissions.";
        PushNotificationController::sendNotification($title,$message);

        // Redirect to tasks route with success message
        return redirect()->route('showTasks')->with('success', 'Data imported successfully.');
    }

    /**
     * Handle duplicate tasks during import (replace and increment resubmission).
     *
     * @param Tasks $existingTask
     * @param array $importedTask
     * @return void
     */
    private function handleDuplicateTask(Tasks $existingTask, array $importedTask, string $inchargeName): void
    {
        // Get resubmission count (handling potential null value)
        $resubmissionCount = $existingTask->resubmission_count ?? 0;

        // Update imported task data with incremented resubmission
        $resubmissionCount = $resubmissionCount + 1;
        $resubmissionDate = ($existingTask->resubmission_date ? $existingTask->resubmission_date . "\n" : '') . $this->getOrdinalNumber($resubmissionCount) . " Submission date: " . $existingTask->date;

        // Delete the existing task
        $existingTask->delete();

        // Create a new task record with updated data
        Tasks::create([
            'date' => $importedTask[0],
            'number' => $importedTask[1],
            'status' => 'pending',
            'type' => $importedTask[3],
            'description' => $importedTask[4],
            'location' => $importedTask[5],
            'side' => $importedTask[6],
            'qty_layer' => $importedTask[7],
            'planned_time' => $importedTask[8],
            'incharge' => $inchargeName,
            'resubmission_count' => $resubmissionCount,
            'resubmission_date' => $resubmissionDate,
        ]);
    }

    public function exportTasks()
    {
//        $settings = [
//            'title' => 'All Tasks',
//        ];
//        $user = Auth::user();
//        return view('task/add',compact('user', 'settings'));
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

    public function updateInspectionDetails(Request $request): \Illuminate\Http\JsonResponse
    {
        $task = Tasks::findOrFail($request->id);
        $task->inspection_details = $request->inspection_details;
        $task->save();

        return response()->json(['message' => 'Inspection details updated successfully']);
    }

    public function updateRfiSubmissionDate(Request $request): \Illuminate\Http\JsonResponse
    {
        $task = Tasks::findOrFail($request->id);
        $task->rfi_submission_date = $request->date;
        $task->save();

        return response()->json(['message' => 'RFI Submission date updated to ']);
    }

    public function updateCompletionDateTime(Request $request): \Illuminate\Http\JsonResponse
    {
        $task = Tasks::findOrFail($request->id);
        $task->completion_time = $request->dateTime;
        $task->save();
        return response()->json(['message' => 'Completion date-time updated to ']);
    }

    public function getOrdinalNumber($number): string
    {
        $number = (int) $number; // Ensure integer type
        $suffix = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
        if ($number % 100 >= 11 && $number % 100 <= 19) {
            $suffix = "th";
        } else {
            $lastDigit = $number % 10;
            $suffix = $suffix[$lastDigit];
        }
        return $number . $suffix;
    }

}

