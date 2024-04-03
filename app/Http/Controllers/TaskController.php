<?php

namespace App\Http\Controllers;

use App\Events\TasksImported;
use App\Http\Controllers\PushNotificationController;
use App\Imports\TaskImport; // Class for handling Task import from Excel/CSV
use App\Models\Author;
use App\Models\Tasks; // Model representing the tasks table
use App\Models\User; // Model representing the users table (assuming user authentication)
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\ModelNotFoundException; // Exception for not found models
use Illuminate\Http\Request; // Represents the incoming HTTP request
use Illuminate\Support\Facades\Auth; // Facade for user authentication
use Illuminate\Support\Facades\DB; // Facade for interacting with the database
use Illuminate\Support\Facades\Log;
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

    public function showDailySummary()
    {
        $user = Auth::user();
        $incharges = User::role('se')->get();
        $title = "Daily Summary";
        return view('task/daily', compact('user','incharges','title'));
    }

    public function dailySummary()
    {
        // Fetch tasks from the database
        $user = Auth::user();
        $tasks = $user ? (
        $user->hasRole('se')
            ? DB::table('tasks')->where('incharge', $user->user_name)->get()
            : ($user->hasRole('admin') ? DB::table('tasks')->get() : [])
        ) : [];

        // Initialize an array to store daily summary
        $dailySummary = [];

        // Iterate over tasks to calculate daily summary
        foreach ($tasks as $task) {
            // Extract date from the task
            $taskDate = $task->date;

            // Increment total tasks count for the date
            $dailySummary[$taskDate] = $dailySummary[$taskDate] ?? [
                'totalTasks' => 0,
                'completedTasks' => 0,
                'embankmentTasks' => 0,
                'structureTasks' => 0,
                'pavementTasks' => 0,
                'rfiSubmissions' => 0
            ];
            $dailySummary[$taskDate]['totalTasks']++;

            // Count completed, embankment, structure, and pavement tasks
            $dailySummary[$taskDate]['completedTasks'] += ($task->status === 'completed') ? 1 : 0;
            $dailySummary[$taskDate]['embankmentTasks'] += ($task->type === 'Embankment') ? 1 : 0;
            $dailySummary[$taskDate]['structureTasks'] += ($task->type === 'Structure') ? 1 : 0;
            $dailySummary[$taskDate]['pavementTasks'] += ($task->type === 'Pavement') ? 1 : 0;
            // Increment RFI submission count if the task has RFI submission
            $dailySummary[$taskDate]['rfiSubmissions'] += ($task->rfi_submission_date) ? 1 : 0;

        }

        // Calculate completion percentage and RFI submission percentage for each date
        foreach ($dailySummary as &$info) {
            $info['completionPercentage'] = (($info['completedTasks'] / $info['totalTasks']) * 100 ?? 0);
            $info['rfiSubmissionPercentage'] = (($info['rfiSubmissions'] / $info['totalTasks']) * 100 ?? 0);
            $info['pendingTasks'] = $info['totalTasks'] - $info['completedTasks'];
            // Round the percentages to one decimal place
            $info['completionPercentage'] = number_format($info['completionPercentage'], 1);
            $info['rfiSubmissionPercentage'] = number_format($info['rfiSubmissionPercentage'], 1);
        }

        $formattedData = [];
        foreach ($dailySummary as $date => $info) {
            $formattedData[] = array_merge(['date' => $date], $info);
        }

        dump($dailySummary);

        return response()->json(['data' => $formattedData]);
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
        try {
            // Query tasks based on date range
            $tasksQuery = Tasks::query();

            // Query tasks based on date range
            if ($request->start !== null && $request->end !== null) {
                // Retrieve start and end date from the request
                $startDate = Carbon::createFromFormat('d M, Y', $request->start)->format('Y-m-d');
                $endDate = Carbon::createFromFormat('d M, Y', $request->end)->format('Y-m-d');
                $tasksQuery->whereBetween('date', [$startDate, $endDate]);
            }

            // Further filter tasks by status
            if ($request->status !== 'all' && $request->status !== null) {
                $status = $request->status;
                $tasksQuery->where('status', $status);
            }

            // Filter tasks by incharge
            if ($request->incharge !== null) {
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

    public function filterSummary(Request $request)
    {
        try {

            // Query tasks based on date range
            $tasksQuery = Tasks::query();

            // Query tasks based on date range
            if ($request->month !== null) {
                // Retrieve month from the request
                $selectedMonth = $request->month;

                // Calculate start and end dates for the selected month
                $startDate = date('Y-m-01', strtotime($selectedMonth));
                $endDate = date('Y-m-t', strtotime($selectedMonth));
                $tasksQuery->whereBetween('date', [$startDate, $endDate]);
            }


            // Filter tasks by incharge
            if ($request->incharge !== null) {
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

        $newSubmissionCount = 0;
        $resubmissionCount = 0;
        $date = $importedTasks[0][0];

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

            $existingTask = Tasks::where('number', $importedTask[1])->first();


            if ($existingTask) {
                $resubmissionCount++;
                // Handle duplicate tasks (handled in separate method)
                $this->handleDuplicateTask($existingTask, $importedTask, $inchargeName);
            } else {
                $newSubmissionCount++;
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
        $title = "Daily tasks updated for {$date}";
        $message = "$newSubmissionCount " . ($newSubmissionCount > 1 ? "new submissions" : "new submission") . " and $resubmissionCount resubmissions.";
        event(new TasksImported($title, $message));

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
            'status' => ($existingTask->status === 'completed' ? 'completed' : 'pending'),
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
//        dd($userId);
        $createdTask->authors()->attach($userId);


        // Delete the existing task
        $existingTask->delete();
    }

    public function exportTasks()
    {
//        $settings = [
//            'title' => 'All Tasks',
//        ];
//        $user = Auth::user();
//        return view('task/add',compact('user', 'settings'));
    }


    public function exportDailySummary()
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

