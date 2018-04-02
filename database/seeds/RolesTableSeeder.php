<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = new Role();
        $role1->name = "superadmin";
        $role1->save();

        $role2 = new Role();
        $role2->name = "publicationadmin";
        $role2->save();

        $role3 = new Role();
        $role3->name = "viewer";
        $role3->save();
    }
}
