<?php

namespace App\Transformers;


use App\Models\RecipeStep;
use League\Fractal\TransformerAbstract;

class RecipeStepTransformer extends TransformerAbstract
{
    public function transform(RecipeStep $record) {
        return [
            'id' => (int) $record->id,
            'order' => $record->order,
            'description' => $record->description,
        ];
    }
}
