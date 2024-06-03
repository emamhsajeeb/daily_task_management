<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\NCR;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function showAttendance()
    {
        $user = Auth::user();
        $title = "Attendance List";
        return view('payroll/attendance', compact( 'user','title'));
    }

    public function allAttendance(Request $request)
    {
        try {

            $users = User::pluck('id');
            $month = $request->input('month');

            $formattedAttendance = [];

            foreach ($users as $userId) {
                // Get the current month's data for the user
                $currentMonthAttendance = Attendance::where('user_id', $userId)
                    ->whereMonth('date', Carbon::parse($month)->month)
                    ->get();

                // Initialize user data array
                $userData = [
                    'user_id' => $userId,
                    'user_name' => User::find($userId)->first_name .' '. User::find($userId)->last_name,
                    'attendance' => [],
                    'symbol_counts' => [
                        "√" => 0, "§" => 0, "×" => 0, "◎" => 0, "■" => 0, "△" => 0, "□" => 0, "☆" => 0, "*" => 0, "○" => 0, "▼" => 0, "/" => 0, "#" => 0
                    ]
                ];

                // Get all dates for the current month
                $startDate = Carbon::parse($month)->startOfMonth();
                $endDate = Carbon::parse($month)->endOfMonth();
                $allDates = [];

                while ($startDate <= $endDate) {
                    $allDates[] = $startDate->toDateString();
                    $startDate->addDay();
                }

                // Loop through all dates of the month
                foreach ($allDates as $date) {
                    // Check if attendance record exists for the date
                    $attendanceRecord = $currentMonthAttendance->firstWhere('date', $date);
                    if ($attendanceRecord) {
                        // Store attendance symbol for the date in the user's attendance array
                        $userData['attendance'][$date] = $attendanceRecord->symbol;

                        // Increment the count for the symbol
                        $userData['symbol_counts'][$attendanceRecord->symbol]++;
                    } else {
                        // If attendance record doesn't exist, set it to null
                        $userData['attendance'][$date] = null;
                    }
                }

                // Add the formatted user data to the array
                $formattedAttendance[] = $userData;
            }

            $formattedAttendance = collect($formattedAttendance)->sortBy('user_id')->values()->all();

            return response()->json([
                'attendance' => $formattedAttendance
            ]);

        } catch (QueryException $e) {
            // Handle database query exceptions
            return response()->json(['error' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateAttendance(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'user_id' => 'required|integer',
                'date' => 'required|date',
                'symbol' => 'required|string|max:255' // Add appropriate validation rules
            ]);

            // Extract validated data
            $userId = $validatedData['user_id'];
            $date = $validatedData['date'];
            $symbol = $validatedData['symbol'];

            // Check if the attendance record already exists
            $attendance = Attendance::where('user_id', $userId)->whereDate('date', $date)->first();

            // If the record doesn't exist, create a new one
            if (!$attendance) {
                $attendance = new Attendance();
                $attendance->user_id = $userId;
                $attendance->date = $date;
            }

            // Update the symbol
            $attendance->symbol = $symbol;
            $attendance->save();

            // Return a success response
            return response()->json(['message' => 'Attendance updated successfully']);
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function clockIn(Request $request)
    {
        try {
            // Validate incoming request data
            $request->validate([
                'user_id' => 'required|integer', // Assuming user_id should be an integer
                'date' => 'required|date_format:Y-m-d',
                'time' => 'required', // Add any validation rules for time if needed
                'location' => 'required', // Add any validation rules for location if needed
            ]);

            // Attempt to create or update the attendance record
            $attendance = Attendance::updateOrCreate(
                ['user_id' => $request->user_id, 'date' => $request->date],
                ['clockin' => $request->time, 'clockin_location' => $request->location, 'symbol' => '√']
            );

            // Update clockin and clockin_location in case they were not set during creation
            $attendance->clockin = $request->time;
            $attendance->clockin_location = $request->location;
            $attendance->save();

            // Return success response
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Handle exceptions
            // You can log the error, return a custom error message, or handle it in any other way you prefer
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function clockOut(Request $request)
    {
        try {
            // Validate incoming request data
            $request->validate([
                'user_id' => 'required|integer', // Assuming user_id should be an integer
                'date' => 'required|date_format:Y-m-d',
                'time' => 'required', // Add any validation rules for time if needed
                'location' => 'required', // Add any validation rules for location if needed
            ]);

            // Find the attendance record for the user and date
            $attendance = Attendance::where('user_id', $request->user_id)
                ->where('date', $request->date)
                ->firstOrFail();

            // Update clockout and clockout_location fields
            $attendance->clockout = $request->time;
            $attendance->clockout_location = $request->location;
            $attendance->save();

            // Return success response
            return response()->json(['success' => true]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle the case where the attendance record is not found
            return response()->json(['error' => 'Attendance record not found.'], 404);
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


}
