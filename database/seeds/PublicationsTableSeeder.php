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
        $pub1->name = 'BendBulletin';
        $pub1->domain = 'www.bendbulletin.com';
        $pub1->GAProfileId = '3577111';
        $pub1->save();

        $pub2 = new Publication();
        $pub2->name = 'UnionDemocrat';
        $pub2->domain = 'www.bendbulletin.com';
        $pub2->GAProfileId = '3577111';
        $pub2->save();

        $pub3 = new Publication();
        $pub3->name = 'BendBulletin';
        $pub3->domain = 'www.bendbulletin.com';
        $pub3->GAProfileId = '3577111';
        $pub3->save();
    }
}
