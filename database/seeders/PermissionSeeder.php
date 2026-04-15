<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
        ['name' => 'correspondence.view', 'display_name' => 'View Correspondence', 'module' => 'Correspondence'],

['name' => 'inbox.view', 'display_name' => 'View Inbox', 'module' => 'Inbox'],
['name' => 'inbox.create', 'display_name' => 'Create Inbox', 'module' => 'Inbox'],
['name' => 'inbox.edit', 'display_name' => 'Edit Inbox', 'module' => 'Inbox'],
['name' => 'inbox.delete', 'display_name' => 'Delete Inbox', 'module' => 'Inbox'],

['name' => 'documents.view', 'display_name' => 'View Documents', 'module' => 'Documents'],

['name' => 'settings.view', 'display_name' => 'View Settings', 'module' => 'Settings'],
['name' => 'correspondence.view', 'display_name' => 'View Correspondence', 'module' => 'Correspondence'],

['name' => 'documents.view', 'display_name' => 'View Documents', 'module' => 'Documents'],

['name' => 'inbox.view', 'display_name' => 'View Inbox', 'module' => 'Inbox'],
['name' => 'inbox.create', 'display_name' => 'Create Inbox', 'module' => 'Inbox'],
['name' => 'inbox.edit', 'display_name' => 'Edit Inbox', 'module' => 'Inbox'],
['name' => 'inbox.delete', 'display_name' => 'Delete Inbox', 'module' => 'Inbox'],

['name' => 'settings.view', 'display_name' => 'View Settings', 'module' => 'Settings'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }
    }
}