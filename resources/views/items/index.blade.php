@extends('layouts.app')

@section('title', 'Kitchen management')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Liste des items
    </h2>
    <button><a href="{{route('dashboard')}}"><- retour a la page d'accueil</a></button>
    <a href="{{ route('items.create') }}">Créer un nouvel items</a>
@endsection

@section('content')

    <ul class="text-gray-900 dark:text-gray-100">
        @foreach($items as $item)
            <li class="mb-4 p-4 bg-white dark:bg-gray-800 rounded shadow">
                <a href="{{route('items.show', $item)}}"><p class="font-bold text-lg">{{ $item->name }}</p>
                    <p>{{ $item->category }}</p></a>
            </li>
        @endforeach
    </ul>
@endsection
