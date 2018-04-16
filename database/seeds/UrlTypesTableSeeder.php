<?php

use App\UrlType;
use Illuminate\Database\Seeder;

class UrlTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type1 = new UrlType();
        $type1->name = "newsarticle";
        $type1->save();

        $type2 = new UrlType();
        $type2->name = "website";
        $type2->save();
    }
}
