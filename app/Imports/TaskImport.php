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
            'type' => $row[2],
            'description' => $row[3],
            'location' => $row[4],
            'side' => $row[5],
            'qty_layer' => $row[6],
            'planned_time' => $row[7]
        ]);
    }
}
