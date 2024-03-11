<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Row;

class TasksImport implements ToModel
{
    public function model(array $row)
    {
        return new Tasks([
            'name' => $row[0],
            'description' => $row[1],
            // add more fields as needed
        ]);
    }

    public function onRow(Row $row)
    {
        $row = $row->toArray();

        // validate the data from the Excel file
        $this->validateRow($row);

        // create a new Tasks model instance and set its properties
        $task = new Tasks([
            'name' => $row[0],
            'description' => $row[1],
            // add more fields as needed
        ]);

        // save the Tasks model instance to the database
        $task->save();
    }

    private function validateRow(array $row): void
    {
        // validate the data from the Excel file
        // throw an exception if the data is invalid
    }
}
class TaskController extends Controller
{

}
