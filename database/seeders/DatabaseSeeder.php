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
                'user_name' => 'emamhosen',
                'first_name' => 'Emam',
                'last_name' => 'Hosen',
                'role' => 'admin',
                'position' => 'IT Executive',
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
                'email' => 'debajha73@gmail.com',
                'password' => Hash::make(123456789),
            ],
            [
                'employee_id' => '126',
                'user_name' => 'prodip',
                'first_name' => 'Prodip',
                'last_name' => 'Saha',
                'role' => 'staff',
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
                'position' => 'Supervision Engineer',
                'email' => 'fozly.rabbi@dbedc.online',
                'password' => Hash::make(123456789),
            ],
            [
                'employee_id' => '126',
                'user_name' => 'habibur',
                'first_name' => 'Habibur',
                'last_name' => 'Rahman',
                'role' => 'staff',
                'position' => 'Supervision Engineer',
                'email' => 'habibur.rahman@dbedc.online',
                'password' => Hash::make(123456789),
            ],
            // Add more users as needed
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
