<?php

namespace App\Enums;

enum MealType: string
{
    case BREAKFAST = 'déjeuner';
    case LUNCH = 'dîner';
    case DINNER = 'souper';

    // Une petite méthode pour récupérer toutes les valeurs facilement
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

}
