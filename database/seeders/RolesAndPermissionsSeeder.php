<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roleAdmin = \Spatie\Permission\Models\Role::create(['name' => 'admin']);
        $roleInstructor = \Spatie\Permission\Models\Role::create(['name' => 'instrutor']);
        $roleStudent = \Spatie\Permission\Models\Role::create(['name' => 'aluno']);
        $roleClient = \Spatie\Permission\Models\Role::create(['name' => 'cliente']);

        $admin = \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@asoftmedia.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole($roleAdmin);
    }
}
