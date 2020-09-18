<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesAndPermissionsSeeder::class);

        $departments = ['Web', 'Mobile', 'AI', 'Data Science', 'UI Design'];
        foreach($departments as $department) {
            App\Department::create(['name' => $department]);
        }
        factory(App\User::class, 15)->create();
    }
}
