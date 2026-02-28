<?php

namespace App\Http\Controllers;

use App\Enums\ItemCategory;
use App\Enums\RecipeType;
use App\Http\Requests\RecipeRequest;
use App\Models\Item;
use App\Models\Recipe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recipes = Recipe::all();
        return view('recipes.index', compact('recipes'));
        // compact('recipes'); et ['recipes' => $recipes]; font exactement la meme chose compact s'il existe une variable qui s'appelle $recipes.
        // Si elle la trouve, elle fabrique le tableau associatif toute seule.
        // hyper fort quand j'ai plusieur valeur a faire passer ex.
        // ['recipes' => $recipes, 'categories' => $categories, 'lists' => $lists] == compact('recipes', 'categories', 'lists')
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('recipes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RecipeRequest $request)
    {
        $recipe = Recipe::create($request->validated());
        return to_route('recipes.show', $recipe)->with('success', 'Recette ajoutée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe) : View
    {
        // 1. Récupère la liste des IDs déjà présents (ex: [1, 5, 8])
        $existingIngredientIds = $recipe->items()->pluck('items.id');

        // 2. Charge seulement ceux qui ne sont PAS dans la liste
        $ingredients = Item::where('category', ItemCategory::FOOD)
            ->whereNotIn('id', $existingIngredientIds)
            ->orderBy('name')
            ->get();

        return view('recipes.show', compact('recipe', 'ingredients'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recipe $recipe): View
    {
        // On récupère les ingrédients pour remplir le select (Optimisation : on utilise get() coté SQL, pas all())
        $ingredients = Item::where('category', ItemCategory::FOOD)->get();

        // On renvoie la vue 'edit' (qu'on va créer juste après)
        return view('recipes.edit', compact('recipe', 'ingredients' ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RecipeRequest $request, Recipe $recipe): RedirectResponse
    {
        // La validation est DÉJÀ faite automatiquement avant d'arriver ici !
        $recipe->update($request->validated());

        return to_route('recipes.index')->with('success', 'Recette modifiée !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $recipe)
    {
        $recipe->delete();

        return to_route('recipes.index')->with('success', 'La recette a été supprimée définitivement.');
    }


    public function addIngredient(Request $request, Recipe $recipe)
    {
        // 1. Validation rapide
        $validated = $request->validate([
            'ingredient_id' => 'required|exists:items,id', // L'item doit exister dans la table items
            'quantity' => 'required|numeric|min:0.1'
        ]);

        // 2. L'attachement Magique (Relation ManyToMany)
        // On dit : "À cette recette, attache cet ingrédient, avec ces infos supplémentaires (pivot)"
        $recipe->items()->attach($validated['ingredient_id'], ['quantity' => $validated['quantity']]);

        // 3. Retour à la page précédente
        return back()->with('success', 'Ingrédient ajouté avec succès !');
    }
    public function removeIngredient(Recipe $recipe, Item $ingredient)
    {
        $recipe->items()->detach($ingredient->id);
        return back()->with('success', 'La recette a été supprimée définitivement.');
    }
}
