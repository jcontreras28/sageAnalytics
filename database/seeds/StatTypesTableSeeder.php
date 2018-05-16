<?php

use App\StatType;
use Illuminate\Database\Seeder;

class StatTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $type1 = new StatType();
        $type1->name = "story";
        $type1->save();
    }
}
