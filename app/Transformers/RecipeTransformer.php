<?php

namespace App\Transformers;

use App\Models\Recipe;
use League\Fractal\TransformerAbstract;

class RecipeTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'steps',
        'ingredients'
    ];

    /**
     * @param Recipe $recipe
     * @return array
     */
    public function transform(Recipe $recipe)
    {
        return [
            'id' => (int)$recipe->id,
            'title' => $recipe->title,
            'description' => $recipe->description,
            'created_at' => $recipe->created_at->format('d-m-Y'),
            'updated_at' => $recipe->updated_at->format('d-m-Y'),
        ];
    }

    public function includeSteps(Recipe $recipe)
    {
        return $this->collection($recipe->steps, new RecipeStepTransformer);
    }

    public function includeIngredients(Recipe $recipe)
    {
        return $this->collection($recipe->ingredients, new IngredientTransformer);
    }
}
