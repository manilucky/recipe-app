<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\RecipeStep;
use App\Transformers\RecipeStepTransformer;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;

class StepsController extends Controller
{
    private $fractal;

    public function __construct()
    {
        $this->fractal = new Manager();
    }

    public function store($recipeId, Request $request)
    {
        $this->validate($request, [
            'order' => 'required',
            'description' => 'required',
        ]);

        $step = Recipe::find($recipeId)->steps()->create($request->all());

        $resource = new Item($step, new RecipeStepTransformer, 'data');
        return $this->fractal->createData($resource)->toArray();
    }

    public function destroy($id) {
        if (!RecipeStep::find($id)) return $this->errorResponse('RecipeStep not found!', 404);

        if (RecipeStep::find($id)->delete()) {
            return $this->customResponse('RecipeStep deleted successfully!', 410);
        }

        return $this->errorResponse('Failed to delete RecipeStep!', 400);
    }

    public function customResponse($message = 'success', $status = 200)
    {
        return response(['status' => $status, 'message' => $message], $status);
    }
}
