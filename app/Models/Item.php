<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
    public function recipes() : BelongsToMany
    {
        return $this->belongsToMany(Recipe::class)->withPivot('quantity');
    }

    protected $fillable = [
        'name',
        'category',
        'stock_quantity',
        'unit',
    ];

    public function formatQuantity(float $quantity): string
    {
        if ($this->unit === 'g' && $quantity >= 1000) {
            return ($quantity / 1000) . ' kg';
        }

        if ($this->unit === 'ml' && $quantity >= 1000) {
            return ($quantity / 1000) . ' L';
        }

        return $quantity . ' ' . $this->unit; // Retourne "500 g" par défaut
    }

    protected $casts = [
        'category' => \App\Enums\ItemCategory::class,
        'unit' => \App\Enums\Unit::class,
    ];
}
