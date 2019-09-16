<?php

use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $recipe = factory('App\Models\Recipe')->create();
        $recipe->ingredients()->saveMany(factory('App\Models\Ingredient', 5)->make());
        $recipe->steps()->saveMany(factory('App\Models\RecipeStep', 5)->make());
    }
}
