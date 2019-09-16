<?php

use Laravel\Lumen\Testing\DatabaseMigrations;

class RecipeTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * /recipes [GET]
     */
    public function testShouldReturnAllRecipes()
    {
        factory('App\Models\Recipe')->create();
        $this->get("api/recipes", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => ['*' =>
                [
                    'title',
                    'description',
                    'created_at',
                    'updated_at',
                ]
            ],
        ]);
    }

    /**
     * /recipes/{id} [GET]
     */
    public function testShouldReturnOneRecipe()
    {
        factory('App\Models\Recipe')->create();

        $this->get("api/recipes/1");
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'title',
                    'description',
                    'created_at',
                    'updated_at',
                ]
            ]
        );
    }

    /**
     * /recipes [POST]
     */
    public function testShouldCreateRecipe()
    {
        $parameters = [
            'title' => 'Sample Recipe',
            'description' => 'Sample description for this recipe.',
        ];
        $this->post("api/recipes", $parameters, []);
        $this->seeInDatabase('recipes', ['title' => $parameters['title']]);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'title',
                    'description',
                    'created_at',
                    'updated_at',
                ]
            ]
        );
    }

    /**
     * /recipes/{id} [PUT]
     */
    public function testShouldUpdateRecipe()
    {
        factory('App\Models\Recipe')->create();
        $parameters = [
            'title' => 'Updated Title',
            'description' => 'Sample description for this recipe.',
        ];
        $this->put("api/recipes/1", $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'title',
                    'description',
                    'created_at',
                    'updated_at',
                ]
            ]
        );
    }

    /**
     * /recipes/{id} [DELETE]
     */
    public function testShouldDeleteRecipe()
    {
        factory('App\Models\Recipe')->create();
        $this->delete("api/recipes/1", [], []);
        $this->seeStatusCode(410);
        $this->seeJsonStructure([
            'status',
            'message'
        ]);
    }

    /**
     * /recipes/{id}/ingredients [POST]
     */
    public function testShouldCreateIngredients()
    {
        $recipe = factory('App\Models\Recipe')->create();

        $parameters = [
            'name' => 'First Ingredient',
            'quantity' => '1ltr',
        ];
        $this->post("api/recipes/" . $recipe->id . "/ingredients", $parameters, []);
        $this->seeInDatabase('ingredients', ['name' => $parameters['name']]);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'name',
                    'quantity',
                ]
            ]
        );
    }

    /**
     * /recipes/ingredients/{id} [DELETE]
     */
    public function testShouldDeleteIngredient()
    {
        $recipe = factory('App\Models\Recipe')->create();
        $ingredient = $recipe->ingredients()->save(factory('App\Models\Ingredient')->make());

        $this->delete("api/recipes/ingredients/" . $ingredient->id, [], []);
        $this->seeStatusCode(410);
        $this->seeJsonStructure([
            'status',
            'message'
        ]);
    }

    /**
     * /recipes/{id}/steps [POST]
     */
    public function testShouldCreateStep()
    {
        $recipe = factory('App\Models\Recipe')->create();

        $parameters = [
            'order' => 1,
            'description' => 'This is the first step!',
        ];
        $this->post("api/recipes/" . $recipe->id . "/steps", $parameters, []);
        $this->seeInDatabase('recipe_steps', ['description' => $parameters['description']]);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'order',
                    'description',
                ]
            ]
        );
    }

    /**
     * /recipes/steps/{id} [DELETE]
     */
    public function testShouldDeleteStep()
    {
        $recipe = factory('App\Models\Recipe')->create();
        $step = $recipe->ingredients()->save(factory('App\Models\RecipeStep')->make());

        $this->delete("api/recipes/steps/" . $step->id, [], []);
        $this->seeStatusCode(410);
        $this->seeJsonStructure([
            'status',
            'message'
        ]);
    }
}
