@extends('layouts.app')

@section('title', 'Modifier un item')

@section('content')
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">

        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-6">
            Modifier : {{ $item->name }}
        </h2>

        <form action="{{ route('items.update', $item) }}" method="post" class="space-y-6">
            @csrf
            @method('PUT') <div>
                <x-input-label for="name" :value="__('Nom de l\'item')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $item->name)" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="category" :value="__('Catégories de l\'item')" />
                <select id="category" name="category" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    @foreach(\App\Enums\ItemCategory::cases() as $category)
                        <option value="{{ $category->value }}" @selected(old('category', $item->category) == $category->value)>
                            {{ $category->value }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('category')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="stock_quantity" :value="__('Quantité en stock')" />
                <x-text-input id="stock_quantity" class="block mt-1 w-full" type="number" step="0.01" name="stock_quantity" :value="old('stock_quantity', $item->stock_quantity)" required />
            </div>

            <div>
                <x-input-label for="unit" :value="__('Unité de l\'item')" />
                <select id="unit" name="unit" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    @foreach(\App\Enums\Unit::cases() as $unit)
                        <option value="{{ $unit->value }}" @selected(old('unit', $item->unit) == $unit->value)>
                            {{ $unit->value }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('unit')" class="mt-2" />
            </div>


            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Mettre à jour') }}</x-primary-button>
                <a href="{{ route('items.show', $item) }}" class="text-sm text-gray-600 dark:text-gray-400">{{ __('Annuler') }}</a>
            </div>
        </form>
    </div>
@endsection
