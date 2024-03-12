<?php

namespace App\Http\Controllers;

use App\Imports\TaskImport;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Maatwebsite\Excel\Excel;




class TaskController extends Controller
{
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
