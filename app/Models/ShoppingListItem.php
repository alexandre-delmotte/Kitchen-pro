<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ShoppingListItem extends Model
{
    protected $fillable = [
        'generated',
        'done',
        'shopping_list_id',
        'item_id',
        'quantity',
    ];

    public function shoppingList() :BelongsTo
    {
        return $this->belongsTo(ShoppingList::class);
    }

    public function item() :BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}

