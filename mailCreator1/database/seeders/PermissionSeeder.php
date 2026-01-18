<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Crear permisos
        $permissions = [
            'view users',
            'create users',
            'edit users',
            'delete users'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Crear roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Asignar permisos a cada rol
        $adminRole->syncPermissions($permissions); // Admin tiene todos los permisos
        $editorRole->syncPermissions(['view users', 'edit users']); // Editor solo ve y edita
        $userRole->syncPermissions([]); // Usuario sin permisos especiales
    }
}
