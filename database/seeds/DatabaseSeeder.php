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
        // $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PublicationsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ActionTypesTableSeeder::class);
        $this->call(ActionsTableSeeder::class);
        $this->call(UrlTypesTableSeeder::class);
    }
}
