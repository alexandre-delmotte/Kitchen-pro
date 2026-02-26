@extends('layouts.app')

@section('title', $item->name)

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ $item->name }}
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
            <a href="{{ route('items.index') }}" class="inline-flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Retour à la liste
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                            {{ $item->name }}
                        </h1>
                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                            {{ $item->category }}
                        </span>
                    </div>

                    <div class="flex items-center text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 px-4 py-2 rounded-lg">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-bold text-lg">{{ $item->stock_quantity }} {{ $item->unit }}</span>
                    </div>
                </div>
            </div>


            <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 flex justify-end items-center gap-4">

                <a href="{{ route('items.edit', $item) }}">
                    <x-primary-button>
                        {{ __('Modifier l\'item') }}
                    </x-primary-button>
                </a>

                <form action="{{ route('items.destroy', $item) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet item ?');">
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
