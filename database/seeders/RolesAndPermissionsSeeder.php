<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // Create permissions
        Permission::firstOrCreate(['name' => 'view users']);
        Permission::firstOrCreate(['name' => 'create users']);
        Permission::firstOrCreate(['name' => 'edit users']);
        Permission::firstOrCreate(['name' => 'delete users']);

        // Create roles and assign permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions([
            'view users',
            'create users',
            'edit users',
            'delete users',
        ]);

        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $editorRole->syncPermissions([
            'view users',
            'create users',
            'edit users',
        ]);

        $viewerRole = Role::firstOrCreate(['name' => 'viewer']);
        $viewerRole->syncPermissions([
            'view users',
        ]);
    }
}
