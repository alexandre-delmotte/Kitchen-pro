<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\PlannedMealController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ShoppingListController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::resources([
    'recipes'=> RecipeController::class,
    'items' => ItemController::class,
]);
Route::resource('planning', PlannedMealController::class)
    ->only(['index', 'store', 'destroy']);

Route::resource('list', ShoppingListController::class)
    ->only(['index', 'store', 'show', 'destroy']);

Route::post('/recipes/{recipe}/ingredients', [RecipeController::class, 'addIngredient'])->name('recipes.ingredients.store');
Route::delete('/recipes/{recipe}/ingredients/{ingredient}', [RecipeController::class, 'removeIngredient'])->name('recipes.ingredients.remove');
require __DIR__.'/auth.php';
