<?php

namespace App\Http\Controllers;

use App\Models\PlannedMeal;
use App\Models\Recipe;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlannedMealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // 1. On récupère la date depuis l'URL (ex: ?date=2026-03-05)
        // Si l'utilisateur n'a rien cliqué, on prend la date du jour.
        $referenceDate = $request->has('date')
            ? Carbon::parse($request->input('date'))
            : Carbon::now();

        // 2. On calcule le début et la fin de la semaine ciblée
        // On utilise copy() pour ne pas modifier l'objet $referenceDate original
        $startOfWeek = $referenceDate->copy()->startOfWeek();
        $endOfWeek = $referenceDate->copy()->endOfWeek();

        // 3. On prépare les dates pour les boutons "Précédent" et "Suivant" de la Vue
        // On recule/avance d'exactement une semaine et on formate en texte (Y-m-d)
        $previousWeek = $startOfWeek->copy()->subWeek()->format('Y-m-d');
        $nextWeek = $startOfWeek->copy()->addWeek()->format('Y-m-d');

        // 4. On récupère les repas planifiés pour CETTE semaine précise
        $plannedMeals = PlannedMeal::with('recipe')
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->orderBy('date')
            ->get();

        // 5. On charge les recettes pour le menu déroulant (pour pouvoir planifier)
        $recipes = Recipe::orderBy('title')->get();

        // On envoie tout cet arsenal à la vue !
        return view('planning.index', compact(
            'plannedMeals',
            'recipes',
            'startOfWeek',
            'endOfWeek',
            'previousWeek',
            'nextWeek'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipe_id' => 'required|exists:recipes,id',
            'date' => 'required|date',
            'meal_type' => 'required|string|in:midi,soir,petit-dej', // Ajuste selon tes besoins
            'portions' => 'required|integer|min:1',
        ]);

        PlannedMeal::create($validated);

        // return back() renvoie l'utilisateur sur la même page (idéal pour rester sur la bonne semaine !)
        return back()->with('success', 'Repas ajouté au planning !');
    }

    public function destroy(PlannedMeal $planning) // N'oublie pas l'import de PlannedMeal
    {
        $planning->delete();

        return back()->with('success', 'Repas retiré du planning.');
    }
}
