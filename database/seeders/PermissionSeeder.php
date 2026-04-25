<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
  $permissions = [
    // Dashboard
    ['name' => 'dashboard.view', 'display_name' => 'View Dashboard', 'module' => 'Dashboard'],
  // department

// auditlogs

['name' => 'audit.view', 'display_name' => 'View Audit Logs', 'module' => 'Audit Trail'],
['name' => 'audit.delete', 'display_name' => 'Delete Audit Logs', 'module' => 'Audit Trail'],

// end

//   Departments

      ['name' => 'departments.view', 'display_name' => 'View Departments', 'module' => 'Departments'],
      ['name' => 'departments.create', 'display_name' => 'Create Departments', 'module' => 'Departments'],
      ['name' => 'departments.edit', 'display_name' => 'Edit Departments', 'module' => 'Departments'],
      ['name' => 'departments.delete', 'display_name' => 'Delete Departments', 'module' => 'Departments'],
    // Users
    ['name' => 'users.view', 'display_name' => 'View Users', 'module' => 'Users'],
    ['name' => 'users.create', 'display_name' => 'Create Users', 'module' => 'Users'],
    ['name' => 'users.edit', 'display_name' => 'Edit Users', 'module' => 'Users'],
    ['name' => 'users.delete', 'display_name' => 'Delete Users', 'module' => 'Users'],

    // Roles
    ['name' => 'roles.view', 'display_name' => 'View Roles', 'module' => 'Roles'],
    ['name' => 'roles.create', 'display_name' => 'Create Roles', 'module' => 'Roles'],
    ['name' => 'roles.edit', 'display_name' => 'Edit Roles', 'module' => 'Roles'],
    ['name' => 'roles.delete', 'display_name' => 'Delete Roles', 'module' => 'Roles'],

    // Employees
    ['name' => 'employees.view', 'display_name' => 'View Employees', 'module' => 'Employees'],
    ['name' => 'employees.create', 'display_name' => 'Create Employees', 'module' => 'Employees'],
    ['name' => 'employees.edit', 'display_name' => 'Edit Employees', 'module' => 'Employees'],
    ['name' => 'employees.delete', 'display_name' => 'Delete Employees', 'module' => 'Employees'],

    // Tasks
    ['name' => 'tasks.view', 'display_name' => 'View Tasks', 'module' => 'Tasks'],
    ['name' => 'tasks.create', 'display_name' => 'Create Tasks', 'module' => 'Tasks'],
    ['name' => 'tasks.edit', 'display_name' => 'Edit Tasks', 'module' => 'Tasks'],
    ['name' => 'tasks.delete', 'display_name' => 'Delete Tasks', 'module' => 'Tasks'],
    ['name' => 'tasks.charts', 'display_name' => 'View Task Charts', 'module' => 'Tasks'],

    // Correspondence / Outbox
    ['name' => 'outbox.view', 'display_name' => 'View Outbox', 'module' => 'Correspondence'],
    ['name' => 'outbox.create', 'display_name' => 'Create Outbox', 'module' => 'Correspondence'],
    ['name' => 'outbox.edit', 'display_name' => 'Edit Outbox', 'module' => 'Correspondence'],
    ['name' => 'outbox.delete', 'display_name' => 'Delete Outbox', 'module' => 'Correspondence'],

    // Inbox
    ['name' => 'inbox.view', 'display_name' => 'View Inbox', 'module' => 'Inbox'],
    ['name' => 'inbox.create', 'display_name' => 'Create Inbox', 'module' => 'Inbox'],
    ['name' => 'inbox.edit', 'display_name' => 'Edit Inbox', 'module' => 'Inbox'],
    ['name' => 'inbox.delete', 'display_name' => 'Delete Inbox', 'module' => 'Inbox'],

    // Documents
    ['name' => 'documents.view', 'display_name' => 'View Documents', 'module' => 'Documents'],
    ['name' => 'documents.create', 'display_name' => 'Create Documents', 'module' => 'Documents'],
    ['name' => 'documents.edit', 'display_name' => 'Edit Documents', 'module' => 'Documents'],
    ['name' => 'documents.delete', 'display_name' => 'Delete Documents', 'module' => 'Documents'],

    // Settings
    ['name' => 'settings.view', 'display_name' => 'View Settings', 'module' => 'Settings'],
    ['name' => 'settings.edit', 'display_name' => 'Edit Settings', 'module' => 'Settings'],
];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }
    }
}