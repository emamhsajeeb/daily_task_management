<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Attendance;
use App\Models\DailySummary;
use App\Models\NCR;
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

        function generateSymbol($remark) {
            $symbols = [
                "√", // attendance
                "§", // personal leave
                "×", // sickness
                "◎", // maternity leave
                "■", // funeral leave
                "△", // annual holiday
                "□", // marital leave
                "☆", // late
                "*",  // leave early
                "○", // business trip
                "▼", // absence
                "/",  // weekend
                "#"   // festival holiday
            ];

            // Choose a random symbol based on the remark
            return $symbols[array_rand($symbols)];
        }

        // Example: Generate bulk data for April
        $bulkData = [];
        $userIds = range(1, 100); // Assuming user IDs range from 1 to 100
        $start_date = '2024-04-01';
        $end_date = '2024-04-30';

        foreach ($userIds as $userId) {
            $currentDate = $start_date;
            while (strtotime($currentDate) <= strtotime($end_date)) {

                // Choose a random remark from the symbols array
                $remark = generateSymbol('attendance');

                $bulkData[] = [
                    'user_id' => $userId,
                    'date' => $currentDate,
                    'symbol' => $remark
                ];
                $currentDate = date("Y-m-d", strtotime($currentDate . "+1 day"));
            }
        }

        // Insert the bulk data into the Attendance table
        foreach ($bulkData as $attendance) {
            Attendance::create($attendance);
        }


    }
}
