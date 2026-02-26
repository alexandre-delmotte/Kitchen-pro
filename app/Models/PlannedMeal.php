<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlannedMeal extends Model
{
    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }
    protected $fillable = [
        'recipe_id',
        'date',
        'meal_type',
        'portions',
    ];
}
