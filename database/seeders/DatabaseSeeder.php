<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $bulkData = [];

        for ($i = 1; $i <= 10; $i++) {
            $bulkData[] = [
                'ncr_no' => 'NCR00' . $i,
                'ref_no' => 'REF00' . $i,
                'ncr_type' => 'Type ' . chr(64 + $i), // Generates Type A, Type B, ..., Type J
                'issue_date' => date('Y-m-d', strtotime("-$i days")),
                'chainages' => 'Chainage ' . chr(64 + $i), // Generates Chainage A, Chainage B, ..., Chainage J
                'details' => 'Details for NCR00' . $i,
                'status' => $i % 2 == 0 ? 'Open' : 'Closed',
                'remarks' => 'Remarks for NCR00' . $i,
            ];
        }

// Insert bulk data into the database
        foreach ($bulkData as $data) {
            NCR::create($data);
        }


    }
}
