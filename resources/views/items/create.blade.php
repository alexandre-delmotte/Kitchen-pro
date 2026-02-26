@extends('layouts.app')

@section('title', 'Créer un item')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Créer un nouvel item') }}
    </h2>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">

        <form action="{{ route('items.store') }}" method="post" class="space-y-6">
            @csrf

            <div>
                <x-input-label for="name" :value="__('Nom de l\'item')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="category" :value="__('Category de l\'item')" />
                <select id="category" name="category" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    @foreach(\App\Enums\ItemCategory::cases() as $category)
                        <option value="{{ $category->value }}" {{ old('type') == $category->value ? 'selected' : '' }}>
                            {{ $category->value }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('category')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="stock_quantity" :value="__('Quantité en stock')" />
                <x-text-input id="stock_quantity" class="block mt-1 w-full" type="number" step="0.01" name="stock_quantity" :value="old('stock_quantity')" required />
                <x-input-error :messages="$errors->get('stock_quantity')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="unit" :value="__('unité')" />
                <select id="unit" name="unit" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    @foreach(\App\Enums\Unit::cases() as $unit)
                        <option value="{{ $unit->value }}" {{ old('unit') == $unit->value ? 'selected' : '' }}>
                            {{ $unit->value }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('unit')" class="mt-2" />
            </div>


            <div class="flex items-center gap-4">
                <x-primary-button>
                    {{ __('Enregistrer') }}
                </x-primary-button>

                <a href="{{ route('recipes.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                    {{ __('Annuler') }}
                </a>
            </div>
        </form>
    </div>
@endsection
