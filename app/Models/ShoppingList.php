<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class ShoppingList extends Model
{
    protected $fillable = [
        'start_date',
        'end_date',
    ];
    public function listItems() :HasMany
    {
        return $this->hasMany(ShoppingListItem::class);
    }
}
