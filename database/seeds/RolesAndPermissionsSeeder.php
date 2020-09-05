<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class RolesAndPermissionsSeeder extends Seeder
{
    private $migrationRequiredMessage = ', Please run "php artisan migrate:refresh" before running the seeder again';
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
       try {
            Permission::create(['name' => 'view collaborators']);
            Permission::create(['name' => 'add collaborators']);
            Permission::create(['name' => 'edit collaborators']);
            Permission::create(['name' => 'delete collaborators']);
            Permission::create(['name' => 'manage accounts']); // ! specific for the manager (super admin)

        } catch(Throwable $e) {
            report($e);
            error_log('ERROR: Permission already exists' . $this->migrationRequiredMessage);
            return;
        }
        
        try {
            // create roles
            $rh = Role::create(['name' => 'rh']);
            $project_manager = Role::create(['name' => 'project manager']);
            $admin = Role::create(['name' => 'admin']);
        } catch(Throwable $e) {
            report($e);
            error_log('ERROR: Role already exists' . $this->migrationRequiredMessage);
            return;
        }


        // give permissions to roles
        try {
            $rh->givePermissionTo(['view collaborators', 'add collaborators', 'edit collaborators', 'delete collaborators']);
            $project_manager->givePermissionTo([]);
            $admin->givePermissionTo(Permission::all());
        } catch(Throwable $e) {
            report($e);
            error_log('ERROR: Role already have that permission' . $this->migrationRequiredMessage);
            return;
        }

        // assign roles to users
        try {
            User::create(['name' => 'RH', 'email' => 'rh@example.com', 'password' => Hash::make('password')])
                ->syncRoles($rh);
            User::create(['name' => 'Project Manager', 'email' => 'projectmanager@example.com', 'password' => Hash::make('password')])
                ->syncRoles($project_manager);
            User::create(['name' => 'Manager', 'email' => 'manager@example.com', 'password' => Hash::make('password')])
                ->syncRoles($admin);
        } catch(Throwable $e) {
            report($e);
            error_log('ERROR: User already exists' . $this->migrationRequiredMessage);
        }
    }
}
