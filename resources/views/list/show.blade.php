@extends('layouts.app')

@section('title', 'Liste de courses')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Liste du {{ \Carbon\Carbon::parse($shoppingList->start_date)->format('d/m/Y') }}
        au {{ \Carbon\Carbon::parse($shoppingList->end_date)->format('d/m/Y') }}
    </h2>
    <form action="{{ route('list.destroy', $shoppingList) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet liste ?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold underline decoration-transparent hover:decoration-red-600 transition">
            Supprimer
        </button>
    </form>
@endsection

@section('content')
    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 mb-8">
        <ul class="space-y-3">
            @foreach($shoppingList->listItems as $listItem)
                <li class="flex items-center gap-4 border-b border-gray-100 dark:border-gray-700 pb-2">
                    <div>
                        <input type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    </div>

                    <div class="font-medium text-gray-900 dark:text-white flex-1">
                        {{ $listItem->item->name }}
                    </div>

                    <div class="text-gray-500 dark:text-gray-400">
                        {{ $listItem->quantity }} {{ $listItem->item->unit ?? 'unité(s)' }}
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
