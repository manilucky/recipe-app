<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
    ];
});

$factory->define(\App\Models\Recipe::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->name,
        'description' => $faker->text,
    ];
});

$factory->define(\App\Models\Ingredient::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'quantity' => $faker->numberBetween(1, 5),
        'recipe_id' => $faker->numberBetween(1, \App\Models\Recipe::count()),
    ];
});

$factory->define(\App\Models\RecipeStep::class, function (Faker\Generator $faker) {
    return [
        'order' => $faker->unique(true)->numberBetween(1, 5), // $faker->unique()->numberBetween(1, 10),
        'description' => $faker->text(),
        'recipe_id' => $faker->numberBetween(1, \App\Models\Recipe::count()),
    ];
});
