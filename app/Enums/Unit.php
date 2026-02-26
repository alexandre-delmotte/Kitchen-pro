<?php

namespace App\Enums;

enum Unit: string
{
    case GRAM = 'g';
    case MILLILITER = 'ml';
    case PIECE = 'pcs';

    // Une petite méthode pour récupérer toutes les valeurs facilement
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
    public function label(): string
    {
        return match($this) {
            self::GRAM => 'Grammes',
            self::MILLILITER => 'Millilitres',
            self::PIECE => 'Pièces',
        };
    }
}
