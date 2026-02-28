@extends('layouts.app')

@section('title', 'listes de courses')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Listes de courses
    </h2>
    <a href="{{route('dashboard')}}"><- retour a la page d'accueil</a>
@endsection

@section('content')

    <ul class="text-gray-900 dark:text-gray-100">
        @foreach($shoppingLists as $shoppingList)
            <li class="mb-4 p-4 bg-white dark:bg-gray-800 rounded shadow">
                <a href="{{route('list.show', $shoppingList)}}"><p class="font-bold text-lg">Liste du {{ $shoppingList->start_date }}</p>
                    <p> au {{ $shoppingList->end_date }}</p></a>
            </li>
        @endforeach
    </ul>
@endsection
