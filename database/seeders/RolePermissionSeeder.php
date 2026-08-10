<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use RuntimeException;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $pivotTable = match (true) {
            Schema::hasTable('permission_role') => 'permission_role',
            Schema::hasTable('role_permission') => 'role_permission',
            default => throw new RuntimeException(
                'Permission-role pivot table does not exist.'
            ),
        };

        $roles = DB::table('roles')
            ->pluck('id', 'name');

        $permissions = DB::table('permissions')
            ->pluck('id', 'name');

        if ($roles->isEmpty()) {
            throw new RuntimeException(
                'No roles exist. Run RoleSeeder first.'
            );
        }

        if ($permissions->isEmpty()) {
            throw new RuntimeException(
                'No permissions exist. Run PermissionSeeder first.'
            );
        }

        /*
         * Super Admin and Admin receive all permissions.
         */
        foreach (['Super Admin', 'Admin'] as $roleName) {
            $roleId = $roles->get($roleName);

            if (!$roleId) {
                continue;
            }

            $this->attachPermissions(
                $pivotTable,
                (int) $roleId,
                $permissions->values()->all()
            );
        }

        /*
         * Manager receives operational permissions,
         * but not dangerous user, role, settings or delete permissions.
         */
        $managerPermissionNames = [
            'dashboard.view',

            'departments.view',
            'employees.view',

            'inbox.view',
            'inbox.create',
            'inbox.edit',
            'inbox.download',
            'inbox.export',

            'outbox.view',
            'outbox.create',
            'outbox.edit',
            'outbox.download',
            'outbox.export',

            'documents.view',
            'documents.download',
            'documents.export',

            'tasks.view',
            'tasks.create',
            'tasks.edit',
            'tasks.assign',
            'tasks.charts',

            'workflows.view',
            'workflows.create',
            'workflows.edit',
            'workflows.approve',
            'workflows.reject',

            'tracking.view',
            'tracking.export',

            'notifications.view',

            'budget_entities.view',
            'introductions.view',
            'introductions.create',
            'introductions.edit',

            'focal_points.view',
            'focal_points.create',
            'focal_points.edit',

            'focal_point_cards.view',
            'focal_point_cards.generate',
            'focal_point_cards.print',
            'focal_point_cards.issue',
        ];

        $managerRoleId = $roles->get('Manager');

        if ($managerRoleId) {
            $managerPermissionIds = collect(
                $managerPermissionNames
            )
                ->map(
                    fn (string $name) =>
                        $permissions->get($name)
                )
                ->filter()
                ->values()
                ->all();

            $this->attachPermissions(
                $pivotTable,
                (int) $managerRoleId,
                $managerPermissionIds
            );
        }

        /*
         * Normal user receives basic access.
         */
        $userPermissionNames = [
            'dashboard.view',
            'notifications.view',
            'inbox.view',
            'outbox.view',
            'documents.view',
            'tasks.view',
            'workflows.view',
            'tracking.view',
        ];

        $userRoleId = $roles->get('User');

        if ($userRoleId) {
            $userPermissionIds = collect(
                $userPermissionNames
            )
                ->map(
                    fn (string $name) =>
                        $permissions->get($name)
                )
                ->filter()
                ->values()
                ->all();

            $this->attachPermissions(
                $pivotTable,
                (int) $userRoleId,
                $userPermissionIds
            );
        }
    }

    private function attachPermissions(
        string $pivotTable,
        int $roleId,
        array $permissionIds
    ): void {
        foreach ($permissionIds as $permissionId) {
            $row = [
                'role_id' => $roleId,
                'permission_id' => (int) $permissionId,
            ];

            if (Schema::hasColumn($pivotTable, 'created_at')) {
                $row['created_at'] = now();
            }

            if (Schema::hasColumn($pivotTable, 'updated_at')) {
                $row['updated_at'] = now();
            }

            DB::table($pivotTable)->insertOrIgnore($row);
        }
    }
}