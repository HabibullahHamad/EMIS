<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'Full system access',
            ],
            [
                'name' => 'director',
                'display_name' => 'Director General',
                'description' => 'Executive approval and monitoring',
            ],
            [
                'name' => 'manager',
                'display_name' => 'Manager',
                'description' => 'Manage tasks and correspondence',
            ],
            [
                'name' => 'staff',
                'display_name' => 'Staff',
                'description' => 'Basic operations',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role['name']],
                $role
            );
        }
    }
}