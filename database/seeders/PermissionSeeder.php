<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'dashboard.view', 'display_name' => 'View Dashboard', 'module' => 'Dashboard'],

            ['name' => 'users.view', 'display_name' => 'View Users', 'module' => 'Users'],
            ['name' => 'users.create', 'display_name' => 'Create Users', 'module' => 'Users'],
            ['name' => 'users.edit', 'display_name' => 'Edit Users', 'module' => 'Users'],
            ['name' => 'users.delete', 'display_name' => 'Delete Users', 'module' => 'Users'],

            ['name' => 'roles.view', 'display_name' => 'View Roles', 'module' => 'Roles'],
            ['name' => 'roles.create', 'display_name' => 'Create Roles', 'module' => 'Roles'],
            ['name' => 'roles.edit', 'display_name' => 'Edit Roles', 'module' => 'Roles'],
            ['name' => 'roles.delete', 'display_name' => 'Delete Roles', 'module' => 'Roles'],

            ['name' => 'employees.view', 'display_name' => 'View Employees', 'module' => 'Employees'],
            ['name' => 'employees.create', 'display_name' => 'Create Employees', 'module' => 'Employees'],
            ['name' => 'employees.edit', 'display_name' => 'Edit Employees', 'module' => 'Employees'],
            ['name' => 'employees.delete', 'display_name' => 'Delete Employees', 'module' => 'Employees'],

            ['name' => 'tasks.view', 'display_name' => 'View Tasks', 'module' => 'Tasks'],
            ['name' => 'tasks.create', 'display_name' => 'Create Tasks', 'module' => 'Tasks'],
            ['name' => 'tasks.edit', 'display_name' => 'Edit Tasks', 'module' => 'Tasks'],
            ['name' => 'tasks.delete', 'display_name' => 'Delete Tasks', 'module' => 'Tasks'],
            ['name' => 'tasks.charts', 'display_name' => 'View Task Charts', 'module' => 'Tasks'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }
    }
}