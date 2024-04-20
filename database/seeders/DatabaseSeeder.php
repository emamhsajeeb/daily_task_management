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
        // Array of user names
        $userNames = [
            "Md. Hafizur Rahman",
            "Shifur Rahaman",
            "Sayed Sifuzzaman",
            "Md. Fuad Amin",
            "Md. Uzzal Mia",
            "Syed Arifur Rahman",
            "Md. Sobuj",
            "Md. Babar Sardar",
            "Md. Main Uddin Sarker",
            "Fahim Al Hassan",
            "Nymul Islam",
            "Md. Farhan Rahman",
            "Md. Emamul Hasan Jasim",
            "Md. Rasedul Islam",
            "Md. Shihab Howlader",
            "Md. Rayhan Kabir",
            "Subrata Kumar Chaki",
            "Amin Miah"
        ];

        // Loop through each user name
        foreach ($userNames as $fullName) {
            // Extract first name and last name
            $fullName = str_replace("Md. ", "", $fullName); // Remove "Md." if present
            $nameParts = explode(" ", $fullName);
            $firstName = $nameParts[0];
            $lastName = isset($nameParts[1]) ? $nameParts[1] : '';

            $user_name = strtolower($firstName . $lastName);

            // Generate email
            $email = strtolower($firstName. '@dhakabypass.com');

            // Generate phone number
            $phone = $this->generatePhoneNumber();

            // Generate joining date (between 2010 and 2023)
            $joiningDate = $this->randomDate('2010-01-01', '2023-12-31');

            // Generate date of birth (between 1950 and 2000)
            $dob = $this->randomDate('1950-01-01', '2000-12-31');

            // Generate random address and about
            $address = $this->generateRandomString(50);
            $about = $this->generateRandomString(100);

            // Insert user into the database
            User::create([
                'user_name' => $user_name,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'password' => Hash::make('123456789'),
                'phone' => $phone,
                'joining_date' => $joiningDate,
                'dob' => $dob,
                'address' => $address,
                'about' => $about
            ]);
        }
    }

    // Function to generate a random phone number
    private function generatePhoneNumber()
    {
        return '01' . mt_rand(10000000, 99999999);
    }

    // Function to generate a random date between two dates
    private function randomDate($startDate, $endDate)
    {
        $startTimestamp = strtotime($startDate);
        $endTimestamp = strtotime($endDate);
        $randomTimestamp = mt_rand($startTimestamp, $endTimestamp);
        return date('Y-m-d', $randomTimestamp);
    }

    // Function to generate a random string of given length
    private function generateRandomString($length)
    {
        return Str::random($length);
    }
}
