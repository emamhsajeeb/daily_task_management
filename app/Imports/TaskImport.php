<?php

namespace App\Imports;

use App\Models\Tasks;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TaskImport implements ToModel
{
    public function model(array $row)
    {
        return new Tasks([
            'date' => $row[0],
            'number' => $row[1],
            'status' => $row[2],
            'type' => $row[3],
            'description' => $row[4],
            'location' => $row[5],
            'side' => $row[6],
            'qty_layer' => $row[7],
            'planned_time' => $row[8],
            'incharge' => $row[9],
        ]);
    }
}
