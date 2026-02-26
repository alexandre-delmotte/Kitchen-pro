@extends('layouts.app')

@section('title', 'Kitchen management')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Liste des recettes
    </h2>
    <button><a href="{{route('dashboard')}}"><- retour a la page d'accueil</a></button>
    <a href="{{ route('recipes.create') }}">Créer une nouvelle recette</a>
@endsection

@section('content')

    <ul class="text-gray-900 dark:text-gray-100">
        @foreach($recipes as $recipe)
           <li class="mb-4 p-4 bg-white dark:bg-gray-800 rounded shadow">
               <a href="{{route('recipes.show', $recipe)}}"><p class="font-bold text-lg">{{ $recipe->title }}</p>
                <p>{{ $recipe->description }}</p></a>
            </li>
        @endforeach
    </ul>
@endsection
