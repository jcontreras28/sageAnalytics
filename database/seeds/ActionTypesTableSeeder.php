<?php

use App\ActionType;
use Illuminate\Database\Seeder;

class ActionTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type1 = new ActionType();
        $type1->name = "Ignore parameter";
        $type1->save();

        $type2 = new ActionType();
        $type2->name = "Gather parameter";
        $type2->save();

        $type3 = new ActionType();
        $type3->name = "GA Events";
        $type3->save();
    }
}
