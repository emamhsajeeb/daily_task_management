<?php

namespace App\Http\Controllers;

use App\Models\DailySummary;
use App\Models\Tasks;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DailySummaryController extends Controller
{

    public function createDailySummary() {

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
        // Get the authenticated user
        $user = Auth::user();
        // Query tasks based on date range
        $tasksQuery = Tasks::query();
        $summaryQuery = DailySummary::query();
        // Check if the user has the 'se' role
        if ($user->hasRole('se')) {
            // If user has the 'se' role, get the daily summaries based on the incharge column
            $tasksQuery->where('incharge', $user->user_name);
            $summaryQuery->where('incharge', $user->user_name);
        }

        $tasks = $tasksQuery->get();
        $dailySummaries = $summaryQuery->get();

        $mergedSummaries = [];

        // Iterate over $dailySummaries
        foreach ($dailySummaries as $summary) {
            $date = $summary['date'];

            // Check if the date has been encountered before
            $found = false;
            foreach ($mergedSummaries as &$merged) {
                if ($merged['date'] == $date) {
                    // If the date is found, merge the current summary into it
                    $merged['totalTasks'] += $summary['totalTasks'];
                    $merged['totalResubmission'] += $summary['totalResubmission'];
                    $merged['embankmentTasks'] += $summary['embankmentTasks'];
                    $merged['structureTasks'] += $summary['structureTasks'];
                    $merged['pavementTasks'] += $summary['pavementTasks'];

                    // Set found flag to true
                    $found = true;
                    break;
                }
            }

            // If the date is not found, add the current summary as a new entry
            if (!$found) {
                $mergedSummaries[] = $summary;
            }
        }
        $dailySummaries = $mergedSummaries;



        // Iterate over tasks to calculate counts and percentages
        foreach ($tasks as $task) {
            // Extract date from the task
            $taskDate = $task->date;

            // Initialize counts and percentages
            $completed = 0;
            $rfiSubmissions = 0;

            // Count completed and RFI submission tasks for the current date
            foreach ($dailySummaries as &$summary) {
                if ($summary->date == $taskDate) {
                    // Count completed tasks
                    if ($task->status === 'completed') {
                        $completed++;
                    }

                    // Count RFI submissions
                    if ($task->rfi_submission_date) {
                        $rfiSubmissions++;
                    }

                    // Calculate completion and RFI submission percentages
                    $summary->completed = $completed;
                    $summary->pending = $summary->totalTasks - $completed;
                    $summary->rfiSubmissions = $rfiSubmissions;
                    $summary->completionPercentage = ($summary->totalTasks > 0) ? round(($completed / $summary->totalTasks) * 100, 1) : 0;
                    $summary->rfiSubmissionPercentage = ($summary->totalTasks > 0) ? round(($rfiSubmissions / $summary->totalTasks) * 100, 1) : 0;
                }
            }
        }


        return response()->json(['data' => $dailySummaries]);
    }

    public function filterSummary(Request $request)
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
            if ($request->month !== null) {
                // Retrieve month from the request
                $selectedMonth = $request->month;

                // Calculate start and end dates for the selected month
                $startDate = date('Y-m-01', strtotime($selectedMonth));
                $endDate = date('Y-m-t', strtotime($selectedMonth));
                $tasksQuery->whereBetween('date', [$startDate, $endDate]);
                $summaryQuery->whereBetween('date', [$startDate, $endDate]);
            }


            // Filter tasks by incharge
            if ($request->incharge !== 'all' && $request->incharge !== null) {
                $incharge = $request->incharge;
                $tasksQuery->where('incharge', $incharge);
                $summaryQuery->where('incharge', $incharge);
            }

            // Retrieve filtered tasks
            $filteredTasks = $tasksQuery->get();
            $filteredSummery = $summaryQuery->get();



            $mergedSummaries = [];

            // Iterate over $dailySummaries
            foreach ($filteredSummery as $summary) {
                $date = $summary['date'];

                // Check if the date has been encountered before
                $found = false;
                foreach ($mergedSummaries as &$merged) {
                    if ($merged['date'] == $date) {
                        // If the date is found, merge the current summary into it
                        $merged['totalTasks'] += $summary['totalTasks'];
                        $merged['totalResubmission'] += $summary['totalResubmission'];
                        $merged['embankmentTasks'] += $summary['embankmentTasks'];
                        $merged['structureTasks'] += $summary['structureTasks'];
                        $merged['pavementTasks'] += $summary['pavementTasks'];

                        // Set found flag to true
                        $found = true;
                        break;
                    }
                }

                // If the date is not found, add the current summary as a new entry
                if (!$found) {
                    $mergedSummaries[] = $summary;
                }
            }
            $dailySummaries = $mergedSummaries;

            // Iterate over tasks to calculate counts and percentages
            foreach ($filteredTasks as $task) {
                // Extract date from the task
                $taskDate = $task->date;

                // Initialize counts and percentages
                $completed = 0;
                $rfiSubmissions = 0;

                // Count completed and RFI submission tasks for the current date
                foreach ($dailySummaries as &$summary) {
                    if ($summary->date == $taskDate) {
                        // Count completed tasks
                        if ($task->status === 'completed') {
                            $completed++;
                        }

                        // Count RFI submissions
                        if ($task->rfi_submission_date) {
                            $rfiSubmissions++;
                        }

                        // Calculate completion and RFI submission percentages
                        $summary->completed = $completed;
                        $summary->pending = $summary->totalTasks - $completed;
                        $summary->rfiSubmissions = $rfiSubmissions;
                        $summary->completionPercentage = ($summary->totalTasks > 0) ? round(($completed / $summary->totalTasks) * 100, 1) : 0;
                        $summary->rfiSubmissionPercentage = ($summary->totalTasks > 0) ? round(($rfiSubmissions / $summary->totalTasks) * 100, 1) : 0;
                    }
                }
            }



            // Return JSON response with filtered tasks
            return response()->json([
                'summaries' => $dailySummaries,
                'message' => 'Tasks filtered successfully'
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions that occur during filtering
            return response()->json([
                'error' => 'An error occurred while filtering tasks: ' . $e->getMessage()
            ], 500);
        }
    }

    public function exportDailySummary()
    {
//        $settings = [
//            'title' => 'All Tasks',
//        ];
//        $team = Auth::team();
//        return view('task/add',compact('team', 'settings'));
    }
}
