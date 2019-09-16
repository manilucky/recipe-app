<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'recipes'], function () use ($router) {
        $router->get('', 'RecipeController@index');
        $router->get('{id}', 'RecipeController@show');
        $router->post('', 'RecipeController@store');
        $router->put('{id}', 'RecipeController@update');
        $router->delete('{id}', 'RecipeController@destroy');

        // ingredients
        $router->post('{recipeId}/ingredients', 'IngredientsController@store');
        $router->delete('ingredients/{id}', 'IngredientsController@destroy');

        // steps
        $router->post('{recipeId}/steps', 'StepsController@store');
        $router->delete('steps/{id}', 'StepsController@destroy');
    });
});
