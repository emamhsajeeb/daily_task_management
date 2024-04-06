<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\DailySummary;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $dailySummary = [
            ['date' => '2024-03-21', 'totalTasks' => 185, 'embankmentTasks' => 133, 'pavementTasks' => 8, 'structureTasks' => 44, 'totalResubmission' => 0],
            ['date' => '2024-03-22', 'totalTasks' => 168, 'embankmentTasks' => 124, 'pavementTasks' => 8, 'structureTasks' => 36, 'totalResubmission' => 83],
            ['date' => '2024-03-23', 'totalTasks' => 139, 'embankmentTasks' => 94, 'pavementTasks' => 5, 'structureTasks' => 40, 'totalResubmission' => 78],
            ['date' => '2024-03-24', 'totalTasks' => 136, 'embankmentTasks' => 91, 'pavementTasks' => 5, 'structureTasks' => 40, 'totalResubmission' => 54],
            ['date' => '2024-03-25', 'totalTasks' => 155, 'embankmentTasks' => 110, 'pavementTasks' => 3, 'structureTasks' => 42, 'totalResubmission' => 80],
            ['date' => '2024-03-26', 'totalTasks' => 140, 'embankmentTasks' => 98, 'pavementTasks' => 5, 'structureTasks' => 37, 'totalResubmission' => 63],
            ['date' => '2024-03-27', 'totalTasks' => 208, 'embankmentTasks' => 160, 'pavementTasks' => 5, 'structureTasks' => 43, 'totalResubmission' => 72],
            ['date' => '2024-03-28', 'totalTasks' => 184, 'embankmentTasks' => 127, 'pavementTasks' => 9, 'structureTasks' => 48, 'totalResubmission' => 68],
            ['date' => '2024-03-29', 'totalTasks' => 162, 'embankmentTasks' => 112, 'pavementTasks' => 10, 'structureTasks' => 40, 'totalResubmission' => 69],
            ['date' => '2024-03-30', 'totalTasks' => 214, 'embankmentTasks' => 159, 'pavementTasks' => 8, 'structureTasks' => 47, 'totalResubmission' => 80],
            ['date' => '2024-03-31', 'totalTasks' => 209, 'embankmentTasks' => 151, 'pavementTasks' => 11, 'structureTasks' => 47, 'totalResubmission' => 136],
            ['date' => '2024-04-01', 'totalTasks' => 189, 'embankmentTasks' => 140, 'pavementTasks' => 12, 'structureTasks' => 37, 'totalResubmission' => 121],
            ['date' => '2024-04-02', 'totalTasks' => 206, 'embankmentTasks' => 146, 'pavementTasks' => 13, 'structureTasks' => 47, 'totalResubmission' => 116],
            ['date' => '2024-04-03', 'totalTasks' => 174, 'embankmentTasks' => 118, 'pavementTasks' => 9, 'structureTasks' => 47, 'totalResubmission' => 76],
            ['date' => '2024-04-04', 'totalTasks' => 200, 'embankmentTasks' => 149, 'pavementTasks' => 9, 'structureTasks' => 42, 'totalResubmission' => 64]
        ];

        foreach ($dailySummary as $summary) {
            DailySummary::create($summary);
        }
    }
}
