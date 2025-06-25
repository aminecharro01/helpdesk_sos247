<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Création des rôles
        $roles = [
            'admin',
            'agent',
            'superviseur',
            'collaborateur',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Permissions de base (à adapter selon tes besoins)
        $permissions = [
            'tickets.create',
            'tickets.view',
            'tickets.update',
            'tickets.delete',
            'tickets.assign',
            'tickets.comment',
            'users.manage',
            'categories.manage',
            'priorities.manage',
            'reporting.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Attribution des permissions à chaque rôle
        Role::findByName('admin')->givePermissionTo(Permission::all());

        Role::findByName('agent')->givePermissionTo([
            'tickets.view',
            'tickets.update',
            'tickets.comment',
            'tickets.assign',
            'reporting.view',
        ]);

        Role::findByName('superviseur')->givePermissionTo([
            'tickets.view',
            'tickets.assign',
            'reporting.view',
        ]);

        Role::findByName('collaborateur')->givePermissionTo([
            'tickets.create',
            'tickets.view',
            'tickets.comment',
        ]);
    }
}
