<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{

    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'Create-Role', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Roles', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Role', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Role', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Read-Permissions', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Permission', 'guard_name' => 'admin']);


        Permission::create(['name' => 'Create-Admin', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Admins', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Admin', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Admin', 'guard_name' => 'admin']);


        Permission::create(['name' => 'Create-Post', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Posts', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Post', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Post', 'guard_name' => 'admin']);



        $role =  Role::create(['name' => 'Super-Admin', 'guard_name' => 'admin']);
        $role->givePermissionTo(Permission::all());


        $role = Role::create(['name' => 'Author', 'guard_name' => 'admin'])
            ->givePermissionTo(['Create-Post', 'Read-Posts','Update-Post','Delete-Post']);

    }

}
