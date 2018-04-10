<?php

use App\Action;
use Illuminate\Database\Seeder;

class ActionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $act1 = new Action();
        $act1->trigger_word = "referrer";
        $act1->action_type_id = 1;
        $act1->publication_id = 2;
        $act1->save();

        $act2 = new Action();
        $act2->trigger_word = "token";
        $act2->action_type_id = 1;
        $act2->publication_id = 2;
        $act2->save();

        $act3 = new Action();
        $act3->trigger_word = "slideshow";
        $act3->action_type_id = 3;
        $act3->publication_id = 2;
        $act3->save();
    }
}
