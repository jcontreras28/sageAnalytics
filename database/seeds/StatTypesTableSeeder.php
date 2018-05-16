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
        $type1->TypeName = "story";
        $type1->save();

        $type2 = new StatType();
        $type2->TypeName = "all";
        $type2->save();
    }
}
