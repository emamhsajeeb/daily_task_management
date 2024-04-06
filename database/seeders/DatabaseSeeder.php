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
            [ 'date' => '2024-03-21' , 'incharge' => 'debashis' , 'totalTasks' => 55, 'totalResubmission' => 0, 'embankmentTasks' => 50, 'structureTasks' => 5, 'pavementTasks' => 0],
            [ 'date' => '2024-03-21' , 'incharge' => 'habibur' , 'totalTasks' => 21, 'totalResubmission' => 0, 'embankmentTasks' => 12, 'structureTasks' => 8, 'pavementTasks' => 1],
            [ 'date' => '2024-03-21' , 'incharge' => 'prodip' , 'totalTasks' => 28, 'totalResubmission' => 0, 'embankmentTasks' => 5, 'structureTasks' => 16, 'pavementTasks' => 7],
            [ 'date' => '2024-03-21' , 'incharge' => 'rabbi' , 'totalTasks' => 81, 'totalResubmission' => 0, 'embankmentTasks' => 66, 'structureTasks' => 15, 'pavementTasks' => 0],
            [ 'date' => '2024-03-22' , 'incharge' => 'debashis' , 'totalTasks' => 44, 'totalResubmission' => 22, 'embankmentTasks' => 43, 'structureTasks' => 1, 'pavementTasks' => 0],
            [ 'date' => '2024-03-22' , 'incharge' => 'habibur' , 'totalTasks' => 32, 'totalResubmission' => 9, 'embankmentTasks' => 20, 'structureTasks' => 10, 'pavementTasks' => 2],
            [ 'date' => '2024-03-22' , 'incharge' => 'prodip' , 'totalTasks' => 22, 'totalResubmission' => 5, 'embankmentTasks' => 5, 'structureTasks' => 11, 'pavementTasks' => 6],
            [ 'date' => '2024-03-22' , 'incharge' => 'rabbi' , 'totalTasks' => 70, 'totalResubmission' => 47, 'embankmentTasks' => 56, 'structureTasks' => 14, 'pavementTasks' => 0],
            [ 'date' => '2024-03-23' , 'incharge' => 'debashis' , 'totalTasks' => 58, 'totalResubmission' => 30, 'embankmentTasks' => 51, 'structureTasks' => 7, 'pavementTasks' => 0],
            [ 'date' => '2024-03-23' , 'incharge' => 'habibur' , 'totalTasks' => 23, 'totalResubmission' => 14, 'embankmentTasks' => 16, 'structureTasks' => 6, 'pavementTasks' => 1],
            [ 'date' => '2024-03-23' , 'incharge' => 'prodip' , 'totalTasks' => 19, 'totalResubmission' => 10, 'embankmentTasks' => 5, 'structureTasks' => 10, 'pavementTasks' => 4],
            [ 'date' => '2024-03-23' , 'incharge' => 'rabbi' , 'totalTasks' => 39, 'totalResubmission' => 24, 'embankmentTasks' => 22, 'structureTasks' => 17, 'pavementTasks' => 0],
            [ 'date' => '2024-03-24' , 'incharge' => 'debashis' , 'totalTasks' => 46, 'totalResubmission' => 26, 'embankmentTasks' => 42, 'structureTasks' => 4, 'pavementTasks' => 0],
            [ 'date' => '2024-03-24' , 'incharge' => 'habibur' , 'totalTasks' => 32, 'totalResubmission' => 8, 'embankmentTasks' => 17, 'structureTasks' => 13, 'pavementTasks' => 2],
            [ 'date' => '2024-03-24' , 'incharge' => 'prodip' , 'totalTasks' => 24, 'totalResubmission' => 5, 'embankmentTasks' => 6, 'structureTasks' => 15, 'pavementTasks' => 3],
            [ 'date' => '2024-03-24' , 'incharge' => 'rabbi' , 'totalTasks' => 34, 'totalResubmission' => 15, 'embankmentTasks' => 26, 'structureTasks' => 8, 'pavementTasks' => 0],
            [ 'date' => '2024-03-25' , 'incharge' => 'debashis' , 'totalTasks' => 46, 'totalResubmission' => 37, 'embankmentTasks' => 42, 'structureTasks' => 4, 'pavementTasks' => 0],
            [ 'date' => '2024-03-25' , 'incharge' => 'habibur' , 'totalTasks' => 27, 'totalResubmission' => 17, 'embankmentTasks' => 18, 'structureTasks' => 9, 'pavementTasks' => 0],
            [ 'date' => '2024-03-25' , 'incharge' => 'prodip' , 'totalTasks' => 25, 'totalResubmission' => 5, 'embankmentTasks' => 2, 'structureTasks' => 20, 'pavementTasks' => 3],
            [ 'date' => '2024-03-25' , 'incharge' => 'rabbi' , 'totalTasks' => 57, 'totalResubmission' => 21, 'embankmentTasks' => 48, 'structureTasks' => 9, 'pavementTasks' => 0],
            [ 'date' => '2024-03-26' , 'incharge' => 'debashis' , 'totalTasks' => 58, 'totalResubmission' => 33, 'embankmentTasks' => 53, 'structureTasks' => 4, 'pavementTasks' => 1],
            [ 'date' => '2024-03-26' , 'incharge' => 'habibur' , 'totalTasks' => 28, 'totalResubmission' => 11, 'embankmentTasks' => 19, 'structureTasks' => 8, 'pavementTasks' => 1],
            [ 'date' => '2024-03-26' , 'incharge' => 'prodip' , 'totalTasks' => 25, 'totalResubmission' => 2, 'embankmentTasks' => 5, 'structureTasks' => 17, 'pavementTasks' => 3],
            [ 'date' => '2024-03-26' , 'incharge' => 'rabbi' , 'totalTasks' => 29, 'totalResubmission' => 17, 'embankmentTasks' => 21, 'structureTasks' => 8, 'pavementTasks' => 0],
            [ 'date' => '2024-03-27' , 'incharge' => 'debashis' , 'totalTasks' => 57, 'totalResubmission' => 37, 'embankmentTasks' => 53, 'structureTasks' => 4, 'pavementTasks' => 0],
            [ 'date' => '2024-03-27' , 'incharge' => 'habibur' , 'totalTasks' => 30, 'totalResubmission' => 9, 'embankmentTasks' => 17, 'structureTasks' => 12, 'pavementTasks' => 1],
            [ 'date' => '2024-03-27' , 'incharge' => 'prodip' , 'totalTasks' => 26, 'totalResubmission' => 9, 'embankmentTasks' => 6, 'structureTasks' => 16, 'pavementTasks' => 4],
            [ 'date' => '2024-03-27' , 'incharge' => 'rabbi' , 'totalTasks' => 95, 'totalResubmission' => 17, 'embankmentTasks' => 84, 'structureTasks' => 11, 'pavementTasks' => 0],
            [ 'date' => '2024-03-28' , 'incharge' => 'debashis' , 'totalTasks' => 65, 'totalResubmission' => 33, 'embankmentTasks' => 56, 'structureTasks' => 9, 'pavementTasks' => 0],
            [ 'date' => '2024-03-28' , 'incharge' => 'habibur' , 'totalTasks' => 29, 'totalResubmission' => 11, 'embankmentTasks' => 12, 'structureTasks' => 14, 'pavementTasks' => 3],
            [ 'date' => '2024-03-28' , 'incharge' => 'prodip' , 'totalTasks' => 29, 'totalResubmission' => 8, 'embankmentTasks' => 6, 'structureTasks' => 17, 'pavementTasks' => 6],
            [ 'date' => '2024-03-28' , 'incharge' => 'rabbi' , 'totalTasks' => 61, 'totalResubmission' => 16, 'embankmentTasks' => 53, 'structureTasks' => 8, 'pavementTasks' => 0],
            [ 'date' => '2024-03-29' , 'incharge' => 'debashis' , 'totalTasks' => 65, 'totalResubmission' => 36, 'embankmentTasks' => 62, 'structureTasks' => 3, 'pavementTasks' => 0],
            [ 'date' => '2024-03-29' , 'incharge' => 'habibur' , 'totalTasks' => 29, 'totalResubmission' => 11, 'embankmentTasks' => 18, 'structureTasks' => 10, 'pavementTasks' => 1],
            [ 'date' => '2024-03-29' , 'incharge' => 'prodip' , 'totalTasks' => 34, 'totalResubmission' => 11, 'embankmentTasks' => 8, 'structureTasks' => 17, 'pavementTasks' => 9],
            [ 'date' => '2024-03-29' , 'incharge' => 'rabbi' , 'totalTasks' => 34, 'totalResubmission' => 11, 'embankmentTasks' => 24, 'structureTasks' => 10, 'pavementTasks' => 0],
            [ 'date' => '2024-03-30' , 'incharge' => 'debashis' , 'totalTasks' => 60, 'totalResubmission' => 39, 'embankmentTasks' => 57, 'structureTasks' => 3, 'pavementTasks' => 0],
            [ 'date' => '2024-03-30' , 'incharge' => 'habibur' , 'totalTasks' => 31, 'totalResubmission' => 13, 'embankmentTasks' => 17, 'structureTasks' => 13, 'pavementTasks' => 1],
            [ 'date' => '2024-03-30' , 'incharge' => 'prodip' , 'totalTasks' => 33, 'totalResubmission' => 12, 'embankmentTasks' => 4, 'structureTasks' => 22, 'pavementTasks' => 7],
            [ 'date' => '2024-03-30' , 'incharge' => 'rabbi' , 'totalTasks' => 90, 'totalResubmission' => 16, 'embankmentTasks' => 81, 'structureTasks' => 9, 'pavementTasks' => 0],
            [ 'date' => '2024-03-31' , 'incharge' => 'debashis' , 'totalTasks' => 59, 'totalResubmission' => 38, 'embankmentTasks' => 52, 'structureTasks' => 7, 'pavementTasks' => 0],
            [ 'date' => '2024-03-31' , 'incharge' => 'habibur' , 'totalTasks' => 28, 'totalResubmission' => 14, 'embankmentTasks' => 19, 'structureTasks' => 7, 'pavementTasks' => 2],
            [ 'date' => '2024-03-31' , 'incharge' => 'prodip' , 'totalTasks' => 36, 'totalResubmission' => 10, 'embankmentTasks' => 3, 'structureTasks' => 24, 'pavementTasks' => 9],
            [ 'date' => '2024-03-31' , 'incharge' => 'rabbi' , 'totalTasks' => 86, 'totalResubmission' => 74, 'embankmentTasks' => 77, 'structureTasks' => 9, 'pavementTasks' => 0],
            [ 'date' => '2024-04-01' , 'incharge' => 'debashis' , 'totalTasks' => 45, 'totalResubmission' => 28, 'embankmentTasks' => 44, 'structureTasks' => 0, 'pavementTasks' => 1],
            [ 'date' => '2024-04-01' , 'incharge' => 'habibur' , 'totalTasks' => 29, 'totalResubmission' => 11, 'embankmentTasks' => 15, 'structureTasks' => 10, 'pavementTasks' => 4],
            [ 'date' => '2024-04-01' , 'incharge' => 'prodip' , 'totalTasks' => 28, 'totalResubmission' => 16, 'embankmentTasks' => 3, 'structureTasks' => 18, 'pavementTasks' => 7],
            [ 'date' => '2024-04-01' , 'incharge' => 'rabbi' , 'totalTasks' => 87, 'totalResubmission' => 66, 'embankmentTasks' => 78, 'structureTasks' => 9, 'pavementTasks' => 0],
            [ 'date' => '2024-04-02' , 'incharge' => 'debashis' , 'totalTasks' => 57, 'totalResubmission' => 30, 'embankmentTasks' => 50, 'structureTasks' => 5, 'pavementTasks' => 2],
            [ 'date' => '2024-04-02' , 'incharge' => 'habibur' , 'totalTasks' => 22, 'totalResubmission' => 9, 'embankmentTasks' => 15, 'structureTasks' => 5, 'pavementTasks' => 2],
            [ 'date' => '2024-04-02' , 'incharge' => 'prodip' , 'totalTasks' => 39, 'totalResubmission' => 14, 'embankmentTasks' => 2, 'structureTasks' => 28, 'pavementTasks' => 9],
            [ 'date' => '2024-04-02' , 'incharge' => 'rabbi' , 'totalTasks' => 88, 'totalResubmission' => 63, 'embankmentTasks' => 79, 'structureTasks' => 9, 'pavementTasks' => 0],
            [ 'date' => '2024-04-03' , 'incharge' => 'debashis' , 'totalTasks' => 53, 'totalResubmission' => 36, 'embankmentTasks' => 47, 'structureTasks' => 5, 'pavementTasks' => 1],
            [ 'date' => '2024-04-03' , 'incharge' => 'habibur' , 'totalTasks' => 29, 'totalResubmission' => 9, 'embankmentTasks' => 11, 'structureTasks' => 17, 'pavementTasks' => 1],
            [ 'date' => '2024-04-03' , 'incharge' => 'prodip' , 'totalTasks' => 23, 'totalResubmission' => 12, 'embankmentTasks' => 0, 'structureTasks' => 16, 'pavementTasks' => 7],
            [ 'date' => '2024-04-03' , 'incharge' => 'rabbi' , 'totalTasks' => 69, 'totalResubmission' => 19, 'embankmentTasks' => 60, 'structureTasks' => 9, 'pavementTasks' => 0],
            [ 'date' => '2024-04-04' , 'incharge' => 'debashis' , 'totalTasks' => 47, 'totalResubmission' => 28, 'embankmentTasks' => 45, 'structureTasks' => 2, 'pavementTasks' => 0],
            [ 'date' => '2024-04-04' , 'incharge' => 'habibur' , 'totalTasks' => 19, 'totalResubmission' => 9, 'embankmentTasks' => 15, 'structureTasks' => 4, 'pavementTasks' => 0],
            [ 'date' => '2024-04-04' , 'incharge' => 'prodip' , 'totalTasks' => 35, 'totalResubmission' => 11, 'embankmentTasks' => 0, 'structureTasks' => 26, 'pavementTasks' => 9],
            [ 'date' => '2024-04-04' , 'incharge' => 'rabbi' , 'totalTasks' => 99, 'totalResubmission' => 16, 'embankmentTasks' => 89, 'structureTasks' => 10, 'pavementTasks' => 0]
        ];

        foreach ($dailySummary as $summary) {
            DailySummary::create($summary);
        }
    }
}
