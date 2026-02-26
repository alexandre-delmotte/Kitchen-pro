@extends('layouts.app')

@section('title', 'Mon Planning de Repas')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Planning de la Semaine') }}
        </h2>

        <div class="flex space-x-4">
            <a href="{{ route('planning.index', ['date' => $previousWeek]) }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-300 transition">
                &laquo; Semaine précédente
            </a>
            <span class="py-2 font-bold text-gray-800 dark:text-gray-200">
                Du {{ $startOfWeek->format('d/m') }} au {{ $endOfWeek->format('d/m') }}
            </span>
            <a href="{{ route('planning.index', ['date' => $nextWeek]) }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-300 transition">
                Semaine suivante &raquo;
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 mb-8">
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Ajouter un repas au menu</h3>

            <form action="{{ route('planning.store') }}" method="POST" class="flex flex-wrap gap-4 items-end">
                @csrf

                <div class="flex-1 min-w-[200px]">
                    <x-input-label for="recipe_id" value="Recette" />
                    <select name="recipe_id" id="recipe_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" required>
                        <option value="">-- Choisir une recette --</option>
                        @foreach($recipes as $recipe)
                            <option value="{{ $recipe->id }}">{{ $recipe->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="date" value="Date" />
                    <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required />
                </div>

                <div>
                    <x-input-label for="meal_type" value="Moment" />
                    <select name="meal_type" id="meal_type" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                        <option value="midi">Midi</option>
                        <option value="soir" selected>Soir</option>
                    </select>
                </div>

                <div class="w-24">
                    <x-input-label for="portions" value="Portions" />
                    <x-text-input id="portions" class="block mt-1 w-full" type="number" name="portions" value="2" min="1" required />
                </div>

                <x-primary-button>Planifier</x-primary-button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-7 gap-4">
            @php
                // On crée un clone de la date de début pour pouvoir l'avancer jour par jour dans la boucle
                $currentDay = $startOfWeek->copy();
            @endphp

            @for ($i = 0; $i < 7; $i++)
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">

                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-2 border-b border-gray-200 dark:border-gray-600 text-center">
                        <span class="block text-sm text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                            {{ $currentDay->locale('fr')->translatedFormat('l') }}
                        </span>
                        <span class="block text-xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $currentDay->format('d/m') }}
                        </span>
                    </div>

                    <div class="p-4 space-y-3 min-h-[150px]">
                        @php
                            // On filtre la grosse liste pour ne garder QUE les repas du jour en cours
                            $mealsForToday = $plannedMeals->filter(function($meal) use ($currentDay) {
                                return \Carbon\Carbon::parse($meal->date)->isSameDay($currentDay);
                            });
                        @endphp

                        @forelse ($mealsForToday as $meal)
                            <div class="bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-100 dark:border-indigo-800 p-2 rounded relative group">
                                <p class="font-bold text-sm text-indigo-900 dark:text-indigo-200 leading-tight">
                                    {{ $meal->recipe->title }}
                                </p>
                                <p class="text-xs text-indigo-600 dark:text-indigo-400 mt-1">
                                    {{ ucfirst($meal->meal_type) }} • {{ $meal->portions }} port.
                                </p>

                                <form action="{{ route('planning.destroy', $meal) }}" method="POST" class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700" title="Retirer du menu">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </form>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400 italic text-center py-4">Rien de prévu</p>
                        @endforelse
                    </div>
                </div>

                @php
                    // On avance d'un jour pour la prochaine boucle !
                    $currentDay->addDay();
                @endphp
            @endfor
        </div>

    </div>
@endsection


