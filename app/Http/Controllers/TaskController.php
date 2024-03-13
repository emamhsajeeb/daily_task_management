<?php

namespace App\Http\Controllers;

use App\Imports\TaskImport;
use App\Models\Tasks;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class TaskController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'staff') {
            $tasks = DB::table('tasks')->where('incharge',$user->user_name)->get();
            return view('layouts/tasks', ['tasks' => $tasks,'user' => $user]);
        } elseif ($user->role == 'admin') {
            $tasks = DB::table('tasks')->get();
            return view('layouts/tasks', ['tasks' => $tasks,'user' => $user]);
        }


    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv,ods',
        ]);

        $path = $request->file('file')->store('temp');

        Excel::import(new TaskImport, $path);

        return redirect()->route('tasks')->with('success', 'Data imported successfully.');
    }

}
