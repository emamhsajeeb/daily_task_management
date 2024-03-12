<?php

namespace App\Imports;

use App\Models\Tasks;
use Maatwebsite\Excel\Concerns\ToModel;

class TaskImport implements ToModel
{
    public function model(array $row)
    {
        return new Tasks([
            'number' => $row[0],
            'type' => $row[1],
            'description' => $row[2],
            'location' => $row[3],
            'side' => $row[4],
            'qty_layer' => $row[5],
            'planned_time' => $row[6],
            'incharge' => $row[7],
            'assigned_to' => $row[8],
            'status' => $row[9],
            'completion_time' => $row[10],
        ]);
    }
}
