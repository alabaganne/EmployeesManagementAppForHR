<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'view collaborators']);
        Permission::create(['name' => 'add collaborators']);
        Permission::create(['name' => 'edit collaborators']);
        Permission::create(['name' => 'delete collaborators']);
        Permission::create(['name' => 'manage accounts']); // ! specific for the manager (super admin)

        // create roles
        $rh = Role::create(['name' => 'rh']);
        $project_manager = Role::create(['name' => 'project manager']);
        $manager = Role::create(['name' => 'manager']);

        // give permissions to roles
        $rh->givePermissionTo(['view collaborators', 'add collaborators', 'edit collaborators', 'delete collaborators']);
        $project_manager->givePermissionsTo([]);
        $manager->givePermissionTo(Permission::all());

        // assign roles to users
        User::create(['name' => 'RH', 'email', 'rh@example.com', 'password' => Hash::make('password')])
            ->syncRoles('rh');
        User::create(['name' => 'Project Manager', 'email' => 'projectmanager@example.com', 'password' => Hash::make('password')])
            ->syncRoles('project_manager');
        User::create(['name' => 'Manager', 'email' => 'manager@example.com', 'password' => Hash::make('password')])
            ->syncRoles('manager');
    }
}
