<?php

namespace App\Http\Controllers;

use App\Models\PlannedMeal;
use App\Models\ShoppingList;
use App\Models\ShoppingListItem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ShoppingListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $shoppingLists = ShoppingList::orderBy('end_date', 'desc')->get();
        return view('list.index', compact('shoppingLists'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_date'=> ['required', Rule::date()->format('Y-m-d')->afterOrEqual(today())],
            'end_date'=> ['required', Rule::date()->format('Y-m-d')->afterOrEqual('start_date')],
        ]);

        $shoppingList = ShoppingList::create($validated);

        $plannedMeals = PlannedMeal::with('recipe.items')
            ->whereBetween('date', [$request->start_date, $request->end_date])
            ->orderBy('date')
            ->get();

        $lists = [];

        // BOUCLE 1 : On calcule le BESOIN TOTAL (sans toucher au stock)
        foreach ($plannedMeals as $plannedMeal)
        {
            $items = $plannedMeal->recipe->items;

            foreach($items as $item)
            {
                $calcul = $item->pivot->quantity * ($plannedMeal->portions / $plannedMeal->recipe->portions);

                if (isset($lists[$item->id])) {
                    $lists[$item->id]['quantity'] += $calcul; // On additionne le besoin
                } else {
                    $lists[$item->id] = [
                        'item' => $item, // On stocke l'objet entier pour avoir le stock plus tard !
                        'quantity' => $calcul // Le besoin initial
                    ];
                }
            }
        }

        // BOUCLE 2 : On soustrait le stock UNE SEULE FOIS !
        foreach ($lists as $key => $data)
        {
            $item = $data['item'];
            $totalNeeded = $data['quantity'];

            // Le calcul final magique
            $toBuy = $totalNeeded - $item->stock_quantity;

            // Si ce qu'on doit acheter est strictement supérieur à 0, on sauvegarde !
            if ($toBuy > 0) {
                $shoppingList->listItems()->create([
                    'generated' => true,
                    'done' => false,
                    'shopping_list_id' => $shoppingList->id,
                    'item_id' => $item->id,
                    'quantity' => $toBuy,
                ]);
            }
        }

        return to_route('planning.index')->with('success', 'La liste a bien été créée <a href="' . route('list.show', $shoppingList) . '" class="font-bold underline text-green-800 hover:text-green-900 ml-2">Voir la liste de courses &rarr;</a>');
    }

    /**
     * Display the specified resource.
     */
    public function show(ShoppingList $list)
    {
        $list->load('listItems.item');
        return view('list.show', ['shoppingList' => $list]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShoppingList $list)
    {
        $list->delete();
        return to_route('list.index')->with('success', 'la liste a bien été supprimée');
    }
}
