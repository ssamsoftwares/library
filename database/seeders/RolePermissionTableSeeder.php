<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                "name" => "superadmin"
            ],
            [
                "name" => "manager"
            ],
            [
                "name" => "admin"
            ],
        ];

        $permissions = [
            ["name" => "student-list"],
            ["name" => "student-view"],
            ["name" => "student-create"],
            ["name" => "student-edit"],
            ["name" => "student-delete"],
            ["name" => "plan-list"],
            ["name" => "plan-view"],
            ["name" => "plan-create"],
            ["name" => "plan-edit"],
            ["name" => "plan-delete"],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
