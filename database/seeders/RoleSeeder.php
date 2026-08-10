<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'description' => 'Full system access',
            ],
            [
                'name' => 'Admin',
                'description' => 'System administration access',
            ],
            [
                'name' => 'Manager',
                'description' => 'Operational management access',
            ],
            [
                'name' => 'User',
                'description' => 'Normal system user',
            ],
        ];

        foreach ($roles as $role) {
            $values = [];

            if (Schema::hasColumn('roles', 'description')) {
                $values['description'] = $role['description'];
            }

            if (Schema::hasColumn('roles', 'updated_at')) {
                $values['updated_at'] = now();
            }

            if (Schema::hasColumn('roles', 'created_at')) {
                $values['created_at'] = now();
            }

            DB::table('roles')->updateOrInsert(
                ['name' => $role['name']],
                $values
            );
        }
    }
}