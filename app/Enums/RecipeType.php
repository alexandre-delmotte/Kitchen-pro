<?php

namespace App\Enums;

enum RecipeType: string
{
    case ENTREE = 'Entrée';
    case PLAT = 'Plat Principal';
    case DESSERT = 'Dessert';
    case APERO = 'Apéritif';
    case SNACK = 'Encas';

    // Une petite méthode pour récupérer toutes les valeurs facilement
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
