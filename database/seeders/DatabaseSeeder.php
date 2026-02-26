<?php

namespace Database\Seeders;

use App\Enums\ItemCategory; // N'oublie pas les imports !
use App\Enums\Unit;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Créer ton utilisateur admin (pour ne pas avoir à s'inscrire à chaque fois)
        User::create([
            'name' => 'Alex',
            'email' => 'admin@kitchen.com',
            'password' => Hash::make('1234'), // Mot de passe : password
        ]);

        // 2. Créer quelques ingrédients de base
        $ingredients = [
            ['name' => 'Farine', 'category' => ItemCategory::FOOD, 'unit' => Unit::GRAM, 'stock_quantity' => 1000],
            ['name' => 'Sucre', 'category' => ItemCategory::FOOD, 'unit' => Unit::GRAM, 'stock_quantity' => 500],
            ['name' => 'Lait', 'category' => ItemCategory::DRINK, 'unit' => Unit::MILLILITER, 'stock_quantity' => 1000],
            ['name' => 'Oeufs', 'category' => ItemCategory::FOOD, 'unit' => Unit::PIECE, 'stock_quantity' => 6],
            ['name' => 'Pâtes', 'category' => ItemCategory::FOOD, 'unit' => Unit::GRAM, 'stock_quantity' => 500],
        ];

        foreach ($ingredients as $data) {
            Item::create($data);
        }
    }
}
