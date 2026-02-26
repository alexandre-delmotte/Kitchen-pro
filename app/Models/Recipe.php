<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recipe extends Model
{
    public function items() : BelongsToMany
    {
        return $this->belongsToMany(Item::class)->withPivot('quantity');
    }

    public function plannedMeals() : HasMany
    {
        return $this->hasMany(PlannedMeal::class);
    }

    protected $fillable = [
        'title',
        'type',
        'portions',
        'description',
        'prep_time_minutes'
    ];
    protected $casts = [
        'type' => \App\Enums\RecipeType::class,
    ];
}
