<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = User::create([
            'name' => 'Naman Jain',
            'email' => 'naman17@outlook.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'normal_password'=> 'password',
            'remember_token' => Str::random(10),
        ]);


        $manager = User::create([
            'name' => 'Manager',
            'email' => 'manager@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'normal_password'=> 'password',
            'remember_token' => Str::random(10),
        ]);

        $role = Role::where('name','superadmin')->first();
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $superadmin->assignRole([$role->id]);

        $admin_role = Role::where('name','admin')->first();
        $admin_role->syncPermissions(['student-list','student-view','student-create','plan-list','plan-view','plan-create']);
        $admin->assignRole([$admin_role->id]);

        $m_role = Role::where('name','manager')->first();
        $m_role->syncPermissions(['student-list','student-view','student-create', 'student-edit','plan-list','plan-view','plan-create']);
        $manager->assignRole([$m_role->id]);
    }
}
