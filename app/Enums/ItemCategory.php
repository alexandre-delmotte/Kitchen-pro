<?php

namespace App\Enums;

enum ItemCategory: string
{
case FOOD = 'ingredient';
case NONFOOD = 'non alimentaire';
case DRINK = 'boisson';
case SNACK = 'encas';

// Une petite méthode pour récupérer toutes les valeurs facilement
public static function values(): array
{
return array_column(self::cases(), 'value');
}
}
