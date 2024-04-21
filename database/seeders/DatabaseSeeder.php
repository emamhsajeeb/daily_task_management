<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Attendance;
use App\Models\DailySummary;
use App\Models\NCR;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {

        // Define start and end dates for the current month using Carbon
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();


        // Get all users
        $users = User::pluck('id');

        // Loop through each user
        foreach ($users as $userId) {

            // Generate dates between start and end date
            $allDates = [];
            $currentDate = clone $startDate;
            while ($currentDate->lte($endDate)) {
                $allDates[] = $currentDate->toDateString();
                $currentDate->addDay();
            }

            // Create attendance records for each date
            foreach ($allDates as $date) {
                Attendance::create([
                    'user_id' => $userId,
                    'date' => $date,
                    'symbol' => '√'
                ]);
            }
        }

    }

}
