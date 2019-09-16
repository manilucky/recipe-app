<?php

namespace App\Transformers;


use App\Models\Ingredient;
use League\Fractal\TransformerAbstract;

class IngredientTransformer extends TransformerAbstract
{
    public function transform(Ingredient $record) {
        return [
            'id' => (int) $record->id,
            'name' => $record->name,
            'quantity' => $record->quantity,
        ];
    }
}
