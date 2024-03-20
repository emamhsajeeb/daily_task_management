<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'employee_id' => '123',
                'user_name' => 'abulbashar',
                'first_name' => 'Md. Abul',
                'last_name' => 'Bashar',
                'role' => 'admin',
                'position' => 'QC Manager',
                'address' => 'Employee Address',
                'phone' => '01712345678',
                'passport' => 'A6541654',
                'nid' => '9846541654',
                'email' => 'abasharlged@gmail.com',
                'password' => Hash::make(123456789),
            ],
            [
                'employee_id' => '123',
                'user_name' => 'emamhosen',
                'first_name' => 'Emam',
                'last_name' => 'Hosen',
                'role' => 'admin',
                'position' => 'IT Executive',
                'address' => 'Employee Address',
                'phone' => '01610285004',
                'passport' => 'A6541654',
                'nid' => '9846541654',
                'email' => 'emamhsajeeb@gmail.com',
                'password' => Hash::make(123456789),
            ],
            [
                'employee_id' => '124',
                'user_name' => 'debashis',
                'first_name' => 'Debashis',
                'last_name' => 'Jha',
                'role' => 'staff',
                'position' => 'Supervision Engineer',
                'address' => 'Employee Address',
                'phone' => '01712345678',
                'passport' => 'A6541654',
                'nid' => '9846541654',
                'email' => 'debajha73@gmail.com',
                'password' => Hash::make(123456789),
            ],
            [
                'employee_id' => '126',
                'user_name' => 'prodip',
                'first_name' => 'Prodip',
                'last_name' => 'Saha',
                'role' => 'staff',
                'address' => 'Employee Address',
                'phone' => '01712345678',
                'passport' => 'A6541654',
                'nid' => '9846541654',
                'position' => 'Supervision Engineer',
                'email' => 'prodip678@gmail.com',
                'password' => Hash::make(123456789),
            ],
            [
                'employee_id' => '126',
                'user_name' => 'rabbi',
                'first_name' => 'Fozly',
                'last_name' => 'Rabbi',
                'role' => 'staff',
                'address' => 'Employee Address',
                'phone' => '01712345678',
                'passport' => 'A6541654',
                'nid' => '9846541654',
                'position' => 'Supervision Engineer',
                'email' => 'fozly.rabbi@dhakabypass.com',
                'password' => Hash::make(123456789),
            ],
            [
                'employee_id' => '126',
                'user_name' => 'habibur',
                'first_name' => 'Habibur',
                'last_name' => 'Rahman',
                'role' => 'staff',
                'address' => 'Employee Address',
                'phone' => '01610285004',
                'passport' => 'A6541654',
                'nid' => '9846541654',
                'position' => 'Supervision Engineer',
                'email' => 'habibur.rahman@dhakabypass.com',
                'password' => Hash::make(123456789),
            ],
            // Add more users as needed
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
