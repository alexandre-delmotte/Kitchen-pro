@extends('layouts.app')

@section('title', 'Kitchen management')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Dashboard') }}
    </h2>
@endsection

@section('content')
    <button><a href="{{route('items.index')}}"> voir la liste des items</a></button>  |
    <button><a href="{{route('recipes.index')}}"> voir la liste des recettes</a></button>   |
    <button><a href="{{route('planning.index')}}"> voir le menus</a></button>   |
    <button><a href="{{route('list.index')}}"> voir les listes de courses</a></button>   |
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
@endsection
