<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Transformers\CustomSerializer;
use Illuminate\Http\Request;
use App\Transformers\RecipeTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;

class RecipeController extends Controller
{
    private $fractal;

    public function __construct()
    {
        $this->fractal = new Manager();
        $this->fractal->setSerializer(new CustomSerializer());
    }

    public function index()
    {
        $paginator = Recipe::paginate();
        $recipes = $paginator->getCollection();

        $resource = new Collection($recipes, new RecipeTransformer, 'data');
        return $this->fractal->createData($resource)->toArray();
    }

    public function show($id)
    {
        $this->fractal->parseIncludes(['steps', 'ingredients']);
        $recipe = Recipe::with(['ingredients', 'steps'])->find($id);

        $resource = new Item($recipe, new RecipeTransformer, 'data');
        return $this->fractal->createData($resource)->toArray();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);
        $recipe = Recipe::create($request->all());
        $resource = new Item($recipe, new RecipeTransformer, 'data');
        return $this->fractal->createData($resource)->toArray();
    }

    public function update($id, Request $request)
    {
        // validate request parameters
        $this->validate($request, [
            'title' => 'max:255',
            // 'description' => 'max:255',
        ]);

        // Return error 404 response if recipe was not found
        if (!Recipe::find($id)) return $this->errorResponse('Recipe not found!', 404);

        $recipe = Recipe::find($id)->update($request->all());
        if ($recipe) {
            // return updated data
            $resource = new Item(Recipe::find($id), new RecipeTransformer, 'data');
            return $this->fractal->createData($resource)->toArray();
        }

        // Return error 400 response if updated was not successful
        return $this->errorResponse('Failed to update Recipe!', 400);
    }

    public function destroy($id)
    {
        if (!Recipe::find($id)) return $this->errorResponse('Recipe not found!', 404);

        if (Recipe::find($id)->delete()) {
            return $this->customResponse('Recipe deleted successfully!', 410);
        }

        return $this->errorResponse('Failed to delete Recipe!', 400);
    }

    public function customResponse($message = 'success', $status = 200)
    {
        return response(['status' => $status, 'message' => $message], $status);
    }
}
