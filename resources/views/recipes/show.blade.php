@extends('layouts.app')

@section('title', $recipe->title)

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ $recipe->title }}
    </h2>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Succès !</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="mb-4">
            <a href="{{ route('recipes.index') }}" class="inline-flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Retour à la liste
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                            {{ $recipe->title }}
                        </h1>
                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                            {{ $recipe->type }}
                        </span>
                    </div>

                    <div class="flex items-center text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 px-4 py-2 rounded-lg">
                        <div>
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-bold text-lg">{{ $recipe->prep_time_minutes }} min</span>
                        </div>
                    </div>
                    <div class="flex items-center text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 px-4 py-2 rounded-lg">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-bold text-lg">{{ $recipe->portions }} p.</span>
                    </div>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-8">

                <div class="md:col-span-1 border-r border-gray-200 dark:border-gray-700 pr-0 md:pr-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                        🥕 Ingrédients
                    </h3>

                    @if($recipe->items->count() > 0)
                        <ul class="space-y-2">
                            @foreach($recipe->items as $ingredient)
                                <li class="group relative flex justify-between items-center text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700/50 p-2 rounded pr-8">
                                    <span>{{ $ingredient->name }}</span>
                                    <span class="font-bold text-sm bg-gray-200 dark:bg-gray-600 px-2 py-1 rounded">
                                          {{ $ingredient->pivot->quantity }} {{ $ingredient->unit }}
                                    </span>

                                    <form action="{{ route('recipes.ingredients.remove', ['recipe' => $recipe, 'ingredient' => $ingredient]) }}" method="POST" class="absolute top-1/2 -translate-y-1/2 right-2 opacity-0 group-hover:opacity-100 transition">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700" title="Retirer l'ingrédient">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-sm text-gray-500 italic mb-4">
                            Aucun ingrédient renseigné.
                        </div>
                    @endif
                        <div class="mt-6 bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                            <h4 class="font-bold text-gray-800 dark:text-gray-200 mb-2">Ajouter un ingrédient</h4>

                            <form action="{{ route('recipes.ingredients.store', $recipe) }}" method="POST" class="flex flex-col sm:flex-row gap-2 items-end">
                                @csrf

                                <div class="flex-grow w-full">
                                    <select name="ingredient_id" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                        @foreach($ingredients as $ingredient)
                                            <option value="{{ $ingredient->id }}">
                                                {{ $ingredient->name }} ({{ $ingredient->unit }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="w-full sm:w-32">
                                    <input type="number" name="quantity" placeholder="Qté" step="0.1" min="0" required
                                           class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                </div>

                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow transition">
                                    Ajouter
                                </button>
                            </form>
                        </div>
                </div>

                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                        📝 Instructions
                    </h3>
                    <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 leading-relaxed">
                        {!! nl2br(e($recipe->description)) !!}
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 flex justify-end items-center gap-4">

                <a href="{{ route('recipes.edit', $recipe) }}">
                    <x-primary-button>
                        {{ __('Modifier la recette') }}
                    </x-primary-button>
                </a>

                <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette recette ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold underline decoration-transparent hover:decoration-red-600 transition">
                        Supprimer
                    </button>
                </form>
            </div>

        </div>
    </div>
@endsection
