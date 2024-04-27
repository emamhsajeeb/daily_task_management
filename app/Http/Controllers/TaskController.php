<?php

namespace App\Http\Controllers;

use App\Events\TasksImported;
use App\Http\Controllers\PushNotificationController;
use App\Imports\TaskImport; // Class for handling Task import from Excel/CSV
use App\Models\Author;
use App\Models\DailySummary;
use App\Models\NCR;
use App\Models\Objection;
use App\Models\Tasks; // Model representing the tasks table
use App\Models\User; // Model representing the users table (assuming team authentication)
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\ModelNotFoundException; // Exception for not found models
use Illuminate\Http\Request; // Represents the incoming HTTP request
use Illuminate\Support\Facades\Auth; // Facade for team authentication
use Illuminate\Support\Facades\DB; // Facade for interacting with the database
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

// Facade for working with Excel files

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
        $title = "Task List";
        $ncrs = NCR::all();
        $obejections = Objection::all();
        $incharges = User::role('se');
        return view('task/tasks', compact('user','incharges','title','ncrs','obejections'));
    }

    public function allTasks(Request $request)
    {
        $user = Auth::user();

        $tasks = $user->hasRole('se')
            ? [
                'tasks' => Tasks::with('ncrs')->where('incharge', $user->user_name)->get(),
                'juniors' => User::where('incharge', $user->user_name)->get(),
            ]
            : ($user->hasRole('qci') || $user->hasRole('aqci')
                ? ['tasks' => Tasks::with('ncrs')->where('assigned', $user->user_name)->get()]
                : ($user->hasRole('admin') || $user->hasRole('manager')
                    ? [
                        'tasks' => Tasks::with('ncrs')->get(),
                        'incharges' => User::role('se')->get(),
                    ]
                    : ['tasks' => []]
                )
            );

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
                'location.custom_location' => 'The :attribute must start with \'K\' and be in the range K0 to K48.',
                'side.required' => 'Road Type is required.',
                'qty_layer.required' => $request->input('type') === 'Embankment' ? 'Layer No. is required when the type is Embankment.' : '',
                'completion_time.required' => 'Completion time is required.',
                'qty_layer.string' => 'Quantity/Layer No. is not string'
            ]);

            // Check if a task with the same number already exists
            $existingTask = Tasks::where('number', $validatedData['number'])->first();
            if ($existingTask) {
                return response()->json(['error' => 'A task with the same RFI number already exists.'], 422);
            }

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

            $tasks = $user->hasRole('se')
                ? [
                    'tasks' => Tasks::with('ncrs')->where('incharge', $user->user_name)->get(),
                    'juniors' => User::where('incharge', $user->user_name)->get(),
                    'message' => 'Task added successfully',
                ] : ($user->hasRole('qci') || $user->hasRole('aqci')
                    ? [
                        'tasks' => Tasks::with('ncrs')->where('assigned', $user->user_name)->get(),
                        'message' => 'Task added successfully'
                    ]
                    : ($user->hasRole('admin') || $user->hasRole('manager')
                        ? [
                            'tasks' => Tasks::with('ncrs')->get(),
                            'incharges' => User::role('se')->get(),
                            'message' => 'Task added successfully'
                        ]
                        : ['tasks' => [],
                            'message' => 'Task added successfully'
                        ]
                    )
                );

            // Return a response
            return response()->json($tasks);
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
            // Query tasks based on date range, status, and incharge
            $filteredTasks = Tasks::query()
                ->when($user->hasRole('se'), function ($query) use ($user) {
                    $query->where('incharge', $user->user_name);
                })
                ->when($user->hasRole('qci') || $user->hasRole('aqci'), function ($query) use ($user) {
                    $query->where('assigned', $user->user_name);
                })
                ->when($request->start && $request->end, function ($query) use ($request) {
                    $query->whereBetween('date', [$request->start, $request->end]);
                })
                ->when($request->status && $request->status !== 'all', function ($query) use ($request) {
                    $query->where('status', $request->status);
                })
                ->when($request->incharge && $request->incharge !== 'all', function ($query) use ($request) {
                    $query->where('incharge', $request->incharge);
                })
                ->get();



            // Determine the return array based on user roles
            $tasks = $user->hasRole('se')
                ? [
                    'tasks' => $filteredTasks,
                    'juniors' => User::where('incharge', $user->user_name)->get(),
                    'message' => 'Tasks filtered successfully',
                ] : ($user->hasRole('qci') || $user->hasRole('aqci')
                    ? [
                        'tasks' => $filteredTasks,
                        'message' => 'Tasks filtered successfully',
                    ]
                    : ($user->hasRole('admin') || $user->hasRole('manager')
                        ? [
                            'tasks' => $filteredTasks,
                            'incharges' => User::role('se')->get(),
                            'message' => 'Tasks filtered successfully',
                        ]
                        : [
                            'tasks' => [],
                            'message' => 'Tasks filtered successfully',
                        ]
                    )
                );

            // Return a response
            return response()->json($tasks);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function importCSV(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:xlsx,csv,ods',
            ]);

            $path = $request->file('file')->store('temp'); // Store uploaded file temporarily

            $importedTasks = Excel::toArray(new TaskImport, $path)[0]; // Import data using TaskImport

            // Validate imported tasks with custom messages
            $validator = Validator::make($importedTasks, [
                '*.0' => 'required|date_format:Y-m-d',
                '*.1' => 'required|string',
                '*.2' => 'required|string|in:Embankment,Structure,Pavement',
                '*.3' => 'required|string',
                '*.4' => 'required|string|custom_location',
            ], [
                '*.0.required' => 'Task number :taskNumber must have a valid date.',
                '*.0.date_format' => 'Task number :taskNumber must be a date in the format Y-m-d.',
                '*.1.required' => 'Task number :taskNumber must have a value for field 1.',
                '*.2.required' => 'Task number :taskNumber must have a value for field 2.',
                '*.2.in' => 'Task number :taskNumber must have a value for field 2 that is either Embankment, Structure, or Pavement.',
                '*.3.required' => 'Task number :taskNumber must have a value for field 3.',
                '*.4.required' => 'Task number :taskNumber must have a value for field 4.',
                '*.4.custom_location' => 'Task number :taskNumber has an invalid custom location: :value',
            ]);

            // Validate the data
            $validator->validate();


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
            return response()->json(['message' => 'Data imported successfully.'], 200);
        } catch (ValidationException $exception) {

            // Return error response with exception message
            return response()->json(['error' => $exception->getMessage()], 500);
        }
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
            return response()->json(['message' => 'Task status updated to ']);
        } catch (ValidationException $e) {
            // Validation failed, return error response
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Other exceptions occurred, return error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function assignTask(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            // Find task by ID
            $task = Tasks::find($request->task_id);

            // If task not found, return 404 error response
            if (!$task) {
                return response()->json(['error' => 'Task not found'], 404);
            }

            $user = User::where('user_name', $request->user_name)->first();

            // Update task status
            $task->assigned = $request->user_name;
            $task->save();

            // Return JSON response with success message
            return response()->json(['message' => 'Task assigned to '.$user->first_name]);
        } catch (ValidationException $e) {
            // Validation failed, return error response
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Other exceptions occurred, return error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function assignIncharge(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            // Find task by ID
            $task = Tasks::find($request->task_id);

            // If task not found, return 404 error response
            if (!$task) {
                return response()->json(['error' => 'Task not found'], 404);
            }

            $user = User::where('user_name', $request->user_name)->first();

            // Update task status
            $task->incharge = $request->user_name;
            $task->save();

            // Return JSON response with success message
            return response()->json(['message' => 'Task incharge updated to '.$user->first_name]);
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

    public function attachNCR(Request $request)
    {
        $taskId = $request->input('task_id');
        $selectedOptions = $request->input('selected_options');

        // Find the task by ID
        $task = Tasks::findOrFail($taskId);

        // Loop through the selected options (NCR numbers) and attach them to the task
        foreach ($selectedOptions as $ncrNo) {
            // Check if the NCR is already attached to the task
            if (!$task->ncrs()->where('ncr_no', $ncrNo)->exists()) {
                // Find the NCR by its ncr_no
                $ncr = NCR::where('ncr_no', $ncrNo)->firstOrFail();
                $task->ncrs()->attach($ncr->id);
            }
        }

        // Retrieve the updated task data
        $updatedTask = Tasks::with('ncrs')->findOrFail($taskId);

        // Return response with success message and updated row data
        return response()->json(['message' => 'NCRs attached to the task successfully.', 'updatedRowData' => $updatedTask]);
    }


    public function detachNCR(Request $request)
    {
        $taskId = $request->input('task_id');
        $deselectedOption = $request->input('selected_options');

        // Find the task by ID
        $task = Tasks::findOrFail($taskId);

        // Find the NCR by its ncr_no
        $ncr = NCR::where('ncr_no', $deselectedOption)->firstOrFail();

        // Detach the NCR from the task
        $task->ncrs()->detach($ncr->id);

        // Retrieve the updated task data
        $updatedTask = Tasks::with('ncrs')->findOrFail($taskId);

        // Return response with success message and updated row data
        return response()->json(['message' => 'NCR detached from the task successfully.', 'updatedRowData' => $updatedTask]);
    }


}

