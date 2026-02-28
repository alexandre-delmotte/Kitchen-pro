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
            ->whereBetween('date',[$request->start_date,$request->end_date])
            ->orderBy('date')
            ->get();
         $lists = [];
        foreach ($plannedMeals as $plannedMeal)
        {
            $items = $plannedMeal->recipe->items;

            foreach($items as $item)
            {
                $calcul = $item->pivot->quantity * ($plannedMeal->portions / $plannedMeal->recipe->portions);

                if (isset($lists[$item->id]))
                {
                    $lists[$item->id] += $calcul;

                }else{
                    $lists[$item->id] = $calcul;
                }
            }
        }
        foreach ($lists as $key => $value)
        {
            $shoppingList->listItems()->create([
                'generated' => true,
                'done' => false,
                'shopping_list_id' => $shoppingList->id,
                'item_id' => $key,
                'quantity' => $value,
                ]);
        }
        return to_route('planning.index')->with('success', 'La list a bien été crée <a href="' . route('list.show',$shoppingList) . '">voir la liste de courses</a>');
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
