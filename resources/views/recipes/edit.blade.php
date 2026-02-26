@extends('layouts.app')

@section('title', 'Modifier la recette')

@section('content')
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">

        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-6">
            Modifier : {{ $recipe->title }}
        </h2>

        <form action="{{ route('recipes.update', $recipe) }}" method="post" class="space-y-6">
            @csrf
            @method('PUT') <div>
                <x-input-label for="title" :value="__('Titre de la recette')" />
                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $recipe->title)" required />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="type" :value="__('Type de plat')" />
                <select id="type" name="type" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    @foreach(\App\Enums\RecipeType::cases() as $type)
                        <option value="{{ $type->value }}" @selected(old('type', $recipe->type) == $type->value)>
                            {{ $type->value }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('type')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="portions" :value="__('portions')" />
                <x-text-input id="portions" class="block mt-1 w-full" type="number" name="portions" :value="old('portions', $recipe->portions)" required />
            </div>

            <div>
                <x-input-label for="prep_time_minutes" :value="__('Temps (min)')" />
                <x-text-input id="prep_time_minutes" class="block mt-1 w-full" type="number" name="prep_time_minutes" :value="old('prep_time_minutes', $recipe->prep_time_minutes)" required />
            </div>

            <div>
                <x-input-label for="description" :value="__('Instructions')" />
                <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">{{ old('description', $recipe->description) }}</textarea>
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Mettre à jour') }}</x-primary-button>
                <a href="{{ route('recipes.show', $recipe) }}" class="text-sm text-gray-600 dark:text-gray-400">{{ __('Annuler') }}</a>
            </div>
        </form>
    </div>
@endsection
