<?php

namespace App\Http\Controllers;

use App\Events\TasksImported;
use App\Http\Controllers\PushNotificationController;
use App\Imports\TaskImport; // Class for handling Task import from Excel/CSV
use App\Models\Author;
use App\Models\DailySummary;
use App\Models\Tasks; // Model representing the tasks table
use App\Models\User; // Model representing the users table (assuming team authentication)
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\ModelNotFoundException; // Exception for not found models
use Illuminate\Http\Request; // Represents the incoming HTTP request
use Illuminate\Support\Facades\Auth; // Facade for team authentication
use Illuminate\Support\Facades\DB; // Facade for interacting with the database
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
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
        $user = Auth::user();
        $incharges = User::role('se')->get();
        $title = "Task List";
        return view('task/tasks', compact('user','incharges','title'));
    }

    public function allTasks(Request $request)
    {
        $user = Auth::user();

        $tasks = $user ? (
        $user->hasRole('se')
            ? DB::table('tasks')->where('incharge', $user->user_name)->get()
            : ($user->hasRole('admin') ? DB::table('tasks')->get() : [])
        ) : [];

        return response()->json($tasks);
    }

    public function addTask(Request $request)
    {
        $user = Auth::user();

        $inchargeName = '';

        try {
            // Validate incoming request data
            $validatedData = $request->validate([
                'date' => 'required|date',
                'number' => 'required|string',
                'time' => 'required|string',
                'status' => 'required|string',
                'type' => 'required|string',
                'description' => 'required|string',
                'location' => 'required|string|custom_location',
                'side' => 'required|string',
                'qty_layer' => $request->input('type') === 'Embankment' ? 'required|string' : '',
                'completion_time' => $request->input('status') === 'completed' ? 'required|string' : '',
                'inspection_details' => 'nullable|string',
            ],[
                'date.required' => 'RFI Date is required.',
                'number.required' => 'RFI Number is required.',
                'time.required' => 'RFI Time is required.',
                'time.string' => 'RFI Time is not string.',
                'status.required' => 'Status is required.',
                'type.required' => 'Type is required.',
                'description.required' => 'Description is required.',
                'location.required' => 'Location is required.',
                'side.required' => 'Road Type is required.',
                'qty_layer.required' => $request->input('type') === 'Embankment' ? 'Layer No. is required when the type is Embankment.' : '',
                'completion_time.required' => 'Completion time is required.',
                'qty_layer.string' => 'Quantity/Layer No. is not string'
            ]);

            $k = intval(substr($validatedData['location'], 1)); // Extracting the numeric part after 'K'
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

            // Create a new Task instance
            $task = new Tasks();
            $task->date = $validatedData['date'];
            $task->number = $validatedData['number'];
            $task->planned_time = $validatedData['time'];
            $task->status = $validatedData['status'];
            $task->type = $validatedData['type'];
            $task->description = $validatedData['description'];
            $task->location = $validatedData['location'];
            $task->side = $validatedData['side'];
            $task->qty_layer = $validatedData['qty_layer'];
            $task->incharge = $user && $user->hasRole('admin') ? $inchargeName : ($user?->user_name);
            $task->completion_time = $validatedData['completion_time'];
            $task->inspection_details = $validatedData['inspection_details'];

            // Save the task to the database
            $task->save();
            $userId = Auth::user()->id;
            $task->authors()->attach($userId);

            $tasks = $user ? (
            $user->hasRole('se')
                ? DB::table('tasks')->where('incharge', $user->user_name)->get()
                : ($user->hasRole('admin') ? DB::table('tasks')->get() : [])
            ) : [];

            // Return a response
            return response()->json(['message' => 'Task added successfully', 'tasks' => $tasks]);
        } catch (ValidationException $e) {
            // Validation failed, return error response
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Other exceptions occurred, return error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function filterTasks(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();
        try {
            // Query tasks based on date range
            $tasksQuery = Tasks::query();
            $summaryQuery = DailySummary::query();
            // Check if the user has the 'se' role
            if ($user->hasRole('se')) {
                // If user has the 'se' role, get the daily summaries based on the incharge column
                $tasksQuery->where('incharge', $user->user_name);
                $summaryQuery->where('incharge', $user->user_name);
            }

            // Query tasks based on date range
            if ($request->start !== null && $request->end !== null) {
//                // Retrieve start and end date from the request
//                $startDate = Carbon::createFromFormat('d M, Y', $request->start)->format('Y-m-d');
//                $endDate = Carbon::createFromFormat('d M, Y', $request->end)->format('Y-m-d');
                $tasksQuery->whereBetween('date', [$request->start, $request->end]);
            }

            // Further filter tasks by status
            if ($request->status !== 'all' && $request->status !== null) {
                $status = $request->status;
                $tasksQuery->where('status', $status);
            }

            // Filter tasks by incharge
            if ($request->incharge !== 'all' && $request->incharge !== null) {
                $incharge = $request->incharge;
                $tasksQuery->where('incharge', $incharge);
            }

            // Retrieve filtered tasks
            $filteredTasks = $tasksQuery->get();


            // Return JSON response with filtered tasks
            return response()->json([
                'tasks' => $filteredTasks,
                'message' => 'Tasks filtered successfully'
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions that occur during filtering
            return response()->json([
                'error' => 'An error occurred while filtering tasks: ' . $e->getMessage()
            ], 500);
        }
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

        // Validate imported tasks
        $validatedTasks = Validator::make($importedTasks, [
            '*.0' => 'date_format:Y-m-d', // date
            '*.1' => 'required|string', // number
            '*.2' => 'required|string|in:Embankment,Structure,Pavement', // type
            '*.3' => 'required|string', // description
            '*.4' => 'required|string|custom_location',
        ])->validate();

        $newSubmissionCount = 0;
        $date = $importedTasks[0][0];

        // Initialize summary variables
        $inchargeSummary = [];

        foreach ($importedTasks as $importedTask) {
            $inchargeName = '';
            $k = intval(substr($importedTask[4], 1)); // Extracting the numeric part after 'K'

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

            // Initialize incharge summary if not exists
            if (!isset($inchargeSummary[$inchargeName])) {
                $inchargeSummary[$inchargeName] = [
                    'totalTasks' => 0,
                    'totalResubmission' => 0,
                    'embankmentTasks' => 0,
                    'structureTasks' => 0,
                    'pavementTasks' => 0,
                ];
            }
            $inchargeSummary[$inchargeName]['totalTasks']++;

            $existingTask = Tasks::where('number', $importedTask[1])->first();

            // Update incharge summary variables based on task type

            switch ($importedTask[2]) {
                case 'Embankment':
                    $inchargeSummary[$inchargeName]['embankmentTasks']++;
                    break;
                case 'Structure':
                    $inchargeSummary[$inchargeName]['structureTasks']++;
                    break;
                case 'Pavement':
                    $inchargeSummary[$inchargeName]['pavementTasks']++;
                    break;
            }

            if ($existingTask) {
                $inchargeSummary[$inchargeName]['totalResubmission']++;
                // Handle duplicate tasks (handled in separate method)
                $this->handleDuplicateTask($existingTask, $importedTask, $inchargeName);
            } else {
                // Create a new task for non-duplicates
                $createdTask = Tasks::create([
                    'date' => $importedTask[0],
                    'number' => $importedTask[1],
                    'status' => 'new',
                    'type' => $importedTask[2],
                    'description' => $importedTask[3],
                    'location' => $importedTask[4],
                    'side' => $importedTask[5],
                    'qty_layer' => $importedTask[6],
                    'planned_time' => $importedTask[7],
                    'incharge' => $inchargeName,
                ]);

                $userId = Auth::user()->id;
                $createdTask->authors()->attach($userId);
            }
        }

        // Store summary data in DailySummary model for each incharge
        foreach ($inchargeSummary as $inchargeName => $summaryData) {
            DailySummary::create([
                'date' => $date,
                'incharge' => $inchargeName,
                'totalTasks' => $summaryData['totalTasks'],
                'totalResubmission' => $summaryData['totalResubmission'],
                'embankmentTasks' => $summaryData['embankmentTasks'],
                'structureTasks' => $summaryData['structureTasks'],
                'pavementTasks' => $summaryData['pavementTasks'],
            ]);
        }

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

        // Create a new task record with updated data
        $createdTask = Tasks::create([
            'date' => ($existingTask->status === 'completed' ? $existingTask->date : $importedTask[0]),
            'number' => $importedTask[1],
            'status' => ($existingTask->status === 'completed' ? 'completed' : 'resubmission'),
            'type' => $importedTask[2],
            'description' => $importedTask[3],
            'location' => $importedTask[4],
            'side' => $importedTask[5],
            'qty_layer' => $importedTask[6],
            'planned_time' => $importedTask[7],
            'incharge' => $inchargeName,
            'resubmission_count' => $resubmissionCount,
            'resubmission_date' => $resubmissionDate,
        ]);



        $userId = Auth::user()->id;
        $createdTask->authors()->attach($userId);

        // Delete the existing task
        $existingTask->delete();
    }

    public function exportTasks()
    {
//        $settings = [
//            'title' => 'All Tasks',
//        ];
//        $team = Auth::team();
//        return view('task/add',compact('team', 'settings'));
    }




    /**
     * Update the status of a task via AJAX request.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateTaskStatus(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            // Find task by ID
            $task = Tasks::find($request->id);

            // If task not found, return 404 error response
            if (!$task) {
                return response()->json(['error' => 'Task not found'], 404);
            }

            // Validate status field
            $request->validate([
                'status' => 'required|string', // Add your validation rules here
            ]);

            // Update task status
            $task->status = $request->status;
            $task->save();

            // Return JSON response with success message
            return response()->json(['message' => 'Task status updated successfully']);
        } catch (ValidationException $e) {
            // Validation failed, return error response
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Other exceptions occurred, return error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
        $task->status = ($task->status != 'completed') ? 'completed' : $task->status;
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

