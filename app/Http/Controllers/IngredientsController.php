<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Ingredient;
use App\Transformers\IngredientTransformer;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;

class IngredientsController extends Controller
{
    private $fractal;

    public function __construct()
    {
        $this->fractal = new Manager();
    }

    public function store($recipeId, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'quantity' => 'required',
        ]);

        $ingredient = Recipe::find($recipeId)->ingredients()->create($request->all());

        $resource = new Item($ingredient, new IngredientTransformer, 'data');
        return $this->fractal->createData($resource)->toArray();
    }

    public function destroy($id) {
        if (!Ingredient::find($id)) return $this->errorResponse('Ingredient not found!', 404);

        if (Ingredient::find($id)->delete()) {
            return $this->customResponse('Ingredient deleted successfully!', 410);
        }

        return $this->errorResponse('Failed to delete Ingredient!', 400);
    }

    public function customResponse($message = 'success', $status = 200)
    {
        return response(['status' => $status, 'message' => $message], $status);
    }
}
