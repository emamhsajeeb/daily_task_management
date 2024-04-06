<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class tempseed
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $roles = [
            ['name' => 'manager', 'guard_name' => 'web'],
            ['name' => 'admin', 'guard_name' => 'web'],
            ['name' => 'visitor', 'guard_name' => 'web'],
            ['name' => 'se', 'guard_name' => 'web'],
            ['name' => 'qci', 'guard_name' => 'web'],
            ['name' => 'aqci', 'guard_name' => 'web']
        ];

        foreach ($roles as $roleData) {
            Role::create($roleData);
        }

        $permissions = [
            ['name' => 'showTasksSE', 'guard_name' => 'web'],
            ['name' => 'showTasks', 'guard_name' => 'web'],
            ['name' => 'addTaskSE', 'guard_name' => 'web'],
            ['name' => 'addTask', 'guard_name' => 'web'],
            ['name' => 'importTasks', 'guard_name' => 'web'],
            ['name' => 'exportTasks', 'guard_name' => 'web'],
            ['name' => 'importCSV', 'guard_name' => 'web'],
            ['name' => 'updateRfiSubmissionDate', 'guard_name' => 'web'],
            ['name' => 'editProfile', 'guard_name' => 'web'],
            ['name' => 'updateProfile', 'guard_name' => 'web'],
            ['name' => 'deleteUser', 'guard_name' => 'web'],
            ['name' => 'updateTaskStatus', 'guard_name' => 'web'],
            ['name' => 'updateInspectionDetails', 'guard_name' => 'web'],
            ['name' => 'updateCompletionDateTime', 'guard_name' => 'web']
        ];

        foreach ($permissions as $permissionData) {
            Permission::create($permissionData);
        }

        $managerRole = Role::where('name', 'manager')->first();
        $managerPermissions = ['showTasks','exportTasks'];
        // Assign permissions to the 'manager' role
        foreach ($managerPermissions as $permissionName) {
            $permission = Permission::where('name', $permissionName)->first();
            $managerRole->givePermissionTo($permission);
        }
        $adminRole = Role::where('name', 'admin')->first();
        $adminPermissions = ['importTasks', 'addTask', 'exportTasks', 'importCSV', 'updateRfiSubmissionDate', 'editProfile', 'updateProfile', 'deleteUser', 'showTasks','updateTaskStatus', 'updateInspectionDetails', 'updateCompletionDateTime'];
        // Assign permissions to the 'admin' role
        foreach ($adminPermissions as $permissionName) {
            $permission = Permission::where('name', $permissionName)->first();
            $adminRole->givePermissionTo($permission);
        }
        $seRole = Role::where('name', 'se')->first();
        $sePermissions = ['showTasksSE','addTaskSE','updateTaskStatus', 'updateInspectionDetails', 'updateCompletionDateTime'];
        // Assign permissions to the 'admin' role
        foreach ($sePermissions as $permissionName) {
            $permission = Permission::where('name', $permissionName)->first();
            $seRole->givePermissionTo($permission);
        }

        $admins = [
            [
                'employee_id' => '123',
                'user_name' => 'abulbashar',
                'first_name' => 'Md. Abul',
                'last_name' => 'Bashar',
                'position' => 'QC Manager',
                'address' => 'Employee Address',
                'phone' => '01465656565',
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
                'position' => 'IT Executive',
                'address' => 'Employee Address',
                'phone' => '01610285004',
                'passport' => 'A6541654',
                'nid' => '9846541654',
                'email' => 'emamhsajeeb@gmail.com',
                'password' => Hash::make(123456789),
            ]
        ];


        foreach ($admins as $admin) {
            $created = User::create($admin);
            $created->assignRole('admin');
        }

        $ses = [
            [
                'employee_id' => '124',
                'user_name' => 'debashis',
                'first_name' => 'Debashis',
                'last_name' => 'Jha',
                'position' => 'Supervision Engineer',
                'address' => 'Employee Address',
                'phone' => '654654654564',
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
                'address' => 'Employee Address',
                'phone' => '657498435121',
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
                'address' => 'Employee Address',
                'phone' => '98765413651',
                'passport' => '727857',
                'nid' => '785785785',
                'position' => 'Supervision Engineer',
                'email' => 'fozly.rabbi@dhakabypass.com',
                'password' => Hash::make(123456789),
            ],
            [
                'employee_id' => '126',
                'user_name' => 'habibur',
                'first_name' => 'Habibur',
                'last_name' => 'Rahman',
                'address' => 'Employee Address',
                'phone' => '98465135156',
                'passport' => 'A654178578654',
                'nid' => '7457857',
                'position' => 'Supervision Engineer',
                'email' => 'habibur.rahman@dhakabypass.com',
                'password' => Hash::make(123456789),
            ],
            // Add more users as needed
        ];



        foreach ($ses as $se) {
            $created = User::create($se);
            $created->assignRole('se');
        }

        $numberOfAuthors = 6;

        // Loop to insert records with IDs from 1 to $numberOfAuthors
        for ($i = 1; $i <= $numberOfAuthors; $i++) {
            DB::table('authors')->insert([
                'author_id' => $i,
                // Add other columns and their values if needed
                // For example: 'name' => 'Author ' . $i,
            ]);
        }
    }
}
