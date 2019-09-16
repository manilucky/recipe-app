## Required
- PHP 7.2 or later
- composer
- Database (mysql / postgress)
- sqlite (for testing)

## Steps to install
- run `composer install`
- copy `.env.example` to `.env` 
- configure the database details in `.env`
- run `php artsan migrate`
- (optional) run `php artisan db:seed`


## API
- `GET /api/recipes` (get all recipes)
- `POST /api/recipes` (create a new recipe)
- `GET /api/recipes/{id}` (get a recipe by id)
- `POST /api/recipes/{id}` (update a recipe)
- `DELETE /api/recipes/{id}` (delete a recipe)
- `POST /api/recipies/{id}/ingredients` (add a new ingredient to the recipe)
- `POST /api/recipies/{id}/steps` (add a new step to the recipe)
- `DELETE /api/recipies/ingredients/{id}` (delete an ingredient by id)
- `DELETE /api/recipies/steps/{id}` (delete a step by id)


