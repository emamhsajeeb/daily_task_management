<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\NCR;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // Get the current month's data for all users
        $currentMonthAttendance = Attendance::whereMonth('date', Carbon::now()->month)
            ->with('user')
            ->get();

        // Prepare an array to store the formatted attendance data
        $formattedAttendance = [];

        // Loop through each attendance record
        foreach ($currentMonthAttendance as $attendance) {
            // Concatenate first name and last name for the user
            $userName = $attendance->user->firstName . ' ' . $attendance->user->lastName;

            // Add the formatted data to the array
            $formattedAttendance[] = [
                'user_id' => $attendance->user_id,
                'date' => $attendance->date,
                'user_name' => $userName,
                'symbol' => $attendance->symbol
            ];
        }

        return response()->json([
            'attendance' => $formattedAttendance
        ]);
    }
}
