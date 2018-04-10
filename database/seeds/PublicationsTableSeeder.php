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

        $pub0 = new Publication();
        $pub0->name = "none";
        $pub0->domain = "none";
        $pub0->GAProfileId = 0;
        $pub0->email = "none";
        $pub0->ignore_all_params = 0;
        $pub0->phone = 0;;
        $pub0->save();

        $pub1 = new Publication();
        $pub1->name = env('PUB1_DB_SEED_NAME');
        $pub1->domain = env('PUB1_DB_SEED_DOMAIN', 'aaaa');
        $pub1->GAProfileId = env('PUB1_DB_SEED_PROFILEID', 'aaaa');
        $pub1->email = env('PUB1_DB_SEED_EMAIL', 'aaaa');
        $pub1->phone = env('PUB1_DB_SEED_PHONE', '123');
        $pub1->logo = env('PUB1_DB_SEED_LOGO', 'aaaa.png');
        $pub1->ignore_all_params = 0;
        $pub1->save();

        $pub2 = new Publication();
        $pub2->name = env('PUB2_DB_SEED_NAME', 'aaaa');
        $pub2->domain = env('PUB2_DB_SEED_DOMAIN', 'aaaa');
        $pub2->GAProfileId = env('PUB2_DB_SEED_PROFILEID', 'aaaa');
        $pub2->email = env('PUB2_DB_SEED_EMAIL', 'aaaa');
        $pub2->phone = env('PUB2_DB_SEED_PHONE', '123');
        $pub2->logo = env('PUB2_DB_SEED_LOGO', 'aaaa.png');
        $pub2->ignore_all_params = 0;
        $pub2->save();

        $pub3 = new Publication();
        $pub3->name = env('PUB3_DB_SEED_NAME', 'aaaa');
        $pub3->domain = env('PUB3_DB_SEED_DOMAIN', 'aaaa');
        $pub3->GAProfileId = env('PUB3_DB_SEED_PROFILEID', 'aaaa');
        $pub3->email = env('PUB3_DB_SEED_EMAIL', 'aaaa');
        $pub3->phone = env('PUB3_DB_SEED_PHONE', '123');
        $pub3->logo = env('PUB3_DB_SEED_LOGO', 'aaaa.png');
        $pub3->ignore_all_params = 0;
        $pub3->save();
    }
}
