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
            App\Models\Department::create(['name' => $department]);
        }
        factory(App\Models\User::class, 15)->create();
    }
}
