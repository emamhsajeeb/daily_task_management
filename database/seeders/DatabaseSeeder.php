<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {

        // Seed roles and assign permissions
        $roles = [
            [
                'name' => 'aqci',
                'permissions' => ['showTasksSE', 'updateTaskStatus', 'updateInspectionDetails', 'updateCompletionDateTime'],
            ],
            [
                'name' => 'qci',
                'permissions' => ['showTasksSE', 'updateTaskStatus', 'updateInspectionDetails', 'updateCompletionDateTime'],
            ],
            // Add more roles and their permissions as needed
        ];

        foreach ($roles as $roleData) {
            // Find role by name
            $role = Role::where('name', $roleData['name'])->first();

            // Check if role exists
            if ($role) {
                // Assign permissions to role
                $role->givePermissionTo($roleData['permissions']);
            }
        }


    }

}
