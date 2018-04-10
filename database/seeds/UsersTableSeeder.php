<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = new User();
        $user1->name = env('USER1_DB_SEED_NAME');
        $user1->email = env('USER1_DB_SEED_EMAL', 'aaaa@some.com');
        $user1->role_id = 1;
        $user1->publication_id = 1;
        $user1->password = Hash::make(env('USER1_DB_SEED_PASSWORD', 'aaaa'));
        $user1->save();

        $user2 = new User();
        $user2->name = env('USER2_DB_SEED_NAME', 'aaaa');
        $user2->email = env('USER2_DB_SEED_EMAL', 'aaaa@some.com');
        $user2->role_id = 1;
        $user2->publication_id = 1;
        $user2->password = Hash::make(env('USER2_DB_SEED_PASSWORD', 'aaaa'));
        $user2->save();

        $user3 = new User();
        $user3->name = env('USER3_DB_SEED_NAME', 'aaaa');
        $user3->email = env('USER3_DB_SEED_EMAL', 'aaaa@some.com');
        $user3->role_id = 2;
        $user3->publication_id = 2;
        $user3->password = Hash::make(env('USER3_DB_SEED_PASSWORD', 'aaaa'));
        $user3->save();

        $user4 = new User();
        $user4->name = env('USER4_DB_SEED_NAME', 'aaaa');
        $user4->email = env('USER4_DB_SEED_EMAL', 'aaaa@some.com');
        $user4->role_id = 2;
        $user4->publication_id = 2;
        $user4->password = Hash::make(env('USER4_DB_SEED_PASSWORD', 'aaaa'));
        $user4->save();
    }
}
