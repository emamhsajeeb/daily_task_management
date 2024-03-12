<?php

namespace App\Http\Controllers;

use App\Imports\TaskImport;
use App\Models\Tasks;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class TaskController extends Controller
{
    public function show()
    {
        $tasks = Tasks::all();
        return view('layouts/tasks', ['tasks' => Tasks::all(),]);
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv,ods',
        ]);

        $path = $request->file('file')->store('temp');

        Excel::import(new TaskImport, $path);

        return redirect()->back()->with('success', 'Data imported successfully.');
    }

}
