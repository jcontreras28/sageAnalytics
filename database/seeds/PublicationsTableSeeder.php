<?php

use App\Publication;
use Illuminate\Database\Seeder;

class PublicationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $pub1 = new Publication();
        $pub1->name = env('PUB1_DB_SEED_NAME', 'aaaa');
        $pub1->domain = env('PUB1_DB_SEED_DOMAIN', 'aaaa');
        $pub1->GAProfileId = env('PUB1_DB_SEED_PROFILEID', 'aaaa');
        $pub1->save();

        $pub2 = new Publication();
        $pub2->name = env('PUB2_DB_SEED_NAME', 'aaaa');
        $pub2->domain = env('PUB2_DB_SEED_DOMAIN', 'aaaa');
        $pub2->GAProfileId = env('PUB2_DB_SEED_PROFILEID', 'aaaa');
        $pub2->save();

        $pub3 = new Publication();
        $pub3->name = env('PUB3_DB_SEED_NAME', 'aaaa');
        $pub3->domain = env('PUB3_DB_SEED_DOMAIN', 'aaaa');
        $pub3->GAProfileId = env('PUB3_DB_SEED_PROFILEID', 'aaaa');
        $pub3->save();
    }
}
