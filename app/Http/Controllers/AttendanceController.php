<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\NCR;
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
        $attendance = Attendance::all();

        return response()->json([
            'attendance' => $attendance
        ]);
    }
}
