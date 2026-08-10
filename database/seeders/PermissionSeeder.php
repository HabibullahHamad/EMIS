<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Dashboard
            'dashboard.view',

            // Users
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'users.block',
            'users.unblock',

            // Roles
            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',
            'roles.assign_permissions',

            // Departments
            'departments.view',
            'departments.create',
            'departments.edit',
            'departments.delete',

            // Employees
            'employees.view',
            'employees.create',
            'employees.edit',
            'employees.delete',
            'employees.export',

            // Incoming documents
            'inbox.view',
            'inbox.create',
            'inbox.edit',
            'inbox.delete',
            'inbox.download',
            'inbox.export',

            // Outgoing documents
            'outbox.view',
            'outbox.create',
            'outbox.edit',
            'outbox.delete',
            'outbox.download',
            'outbox.export',

            // Documents
            'documents.view',
            'documents.create',
            'documents.edit',
            'documents.delete',
            'documents.download',
            'documents.export',

            // Tasks
            'tasks.view',
            'tasks.create',
            'tasks.edit',
            'tasks.delete',
            'tasks.assign',
            'tasks.charts',

            // Workflows
            'workflows.view',
            'workflows.create',
            'workflows.edit',
            'workflows.delete',
            'workflows.approve',
            'workflows.reject',

            // Tracking
            'tracking.view',
            'tracking.export',

            // Notifications
            'notifications.view',
            'notifications.manage',

            // Audit
            'audit.view',
            'audit.export',

            // Settings
            'settings.view',
            'settings.manage',
            'admin.settings',

            // Budget entities
            'budget_entities.view',
            'budget_entities.create',
            'budget_entities.edit',
            'budget_entities.delete',

            // Introduction letters
            'introductions.view',
            'introductions.create',
            'introductions.edit',
            'introductions.delete',
            'introductions.approve',

            // Focal points
            'focal_points.view',
            'focal_points.create',
            'focal_points.edit',
            'focal_points.delete',
            'focal_points.approve',
            'focal_points.suspend',

            // Focal-point cards
            'focal_point_cards.view',
            'focal_point_cards.generate',
            'focal_point_cards.print',
            'focal_point_cards.issue',
            'focal_point_cards.revoke',
        ];

        foreach ($permissions as $permissionName) {
            $displayName = Str::title(
                str_replace(
                    ['.', '_'],
                    ' ',
                    $permissionName
                )
            );

            $values = [];

            /*
             * Required by your permissions table.
             */
            if (Schema::hasColumn('permissions', 'display_name')) {
                $values['display_name'] = $displayName;
            }

            if (Schema::hasColumn('permissions', 'description')) {
                $values['description'] = $displayName;
            }

            /*
             * Some permission tables contain a module/group field.
             */
            if (Schema::hasColumn('permissions', 'module')) {
                $values['module'] = Str::before(
                    $permissionName,
                    '.'
                );
            }

            if (Schema::hasColumn('permissions', 'group_name')) {
                $values['group_name'] = Str::before(
                    $permissionName,
                    '.'
                );
            }

            if (Schema::hasColumn('permissions', 'guard_name')) {
                $values['guard_name'] = 'web';
            }

            if (Schema::hasColumn('permissions', 'created_at')) {
                $values['created_at'] = now();
            }

            if (Schema::hasColumn('permissions', 'updated_at')) {
                $values['updated_at'] = now();
            }

            DB::table('permissions')->updateOrInsert(
                [
                    'name' => $permissionName,
                ],
                $values
            );
        }
    }
}