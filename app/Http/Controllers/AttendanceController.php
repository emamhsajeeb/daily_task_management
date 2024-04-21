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
            $month = $request->input('month');
            $users = User::with('attendance')->pluck('id');
            $attendances = Attendance::whereMonth('date', Carbon::parse($month)->month)->get();
            $attendancesByUser = $attendances->groupBy('user_id');

            $formattedAttendance = [];

            foreach ($attendancesByUser as $userId => $attendances) {
                $userData = [
                    'user_id' => $userId,
                    'user_name' => User::find($userId)->first_name. ' '. User::find($userId)->last_name,
                    'attendance' => [],
                    'symbol_counts' => []
                ];

                $allDates = [];
                $startDate = Carbon::parse($month)->startOfMonth();
                $endDate = Carbon::parse($month)->endOfMonth();

                while ($startDate <= $endDate) {
                    $allDates[] = $startDate->toDateString();
                    $startDate->addDay();
                }

                foreach ($allDates as $date) {
                    $attendanceRecord = $attendances->firstWhere('date', $date);
                    if ($attendanceRecord) {
                        $userData['attendance'][$date] = $attendanceRecord->symbol;
                    } else {
                        $userData['attendance'][$date] = null;
                    }
                }

                $symbolCounts = array_count_values($attendances->pluck('symbol')->all());
                $userData['symbol_counts'] = $symbolCounts;

                $formattedAttendance[] = $userData;
            }

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

}
